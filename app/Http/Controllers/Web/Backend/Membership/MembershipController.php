<?php

namespace App\Http\Controllers\Web\Backend\Membership;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserMembership;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = UserMembership::with('user')->latest();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill">
                                <h2 class="mb-0 small fw-normal bolder">' . ($data->user->name) . '</h2>
                            </div>';
                })
                ->addColumn('plan_interval', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-primary text-white">
                                <h2 class="text-white mb-0 small fw-normal">' . $data->plan_interval . '</h2>
                            </div>';
                })
                ->addColumn('plan_period_start', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-success text-white">
                                <h2 class="text-white mb-0 small fw-normal">' . date('M d, Y', strtotime($data->plan_period_start)) . '</h2>
                            </div>';
                })
                ->addColumn('plan_period_end', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-warning">
                                <h2 class="text-black mb-0 small fw-normal">' . date('M d, Y', strtotime($data->plan_period_end)) . '</h2>
                            </div>';
                })

                ->addColumn('status', function ($data) {
                    $status = ' <div class="form-check form-switch">';
                    $status .= ' <input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status"';
                    if ($data->status == "active") {
                        $status .= "checked";
                    }
                    $status .= '><label for="customSwitch' . $data->id . '" class="form-check-label" for="customSwitch"></label></div>';

                    return $status;
                })

                ->rawColumns(['name', 'plan_interval', 'plan_period_start', 'plan_period_end', 'status'])
                ->make(true);
        }
        return view('backend.layouts.membership.index');
    }

    //toggle status
    public function status(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $data = UserMembership::findOrFail($id);

        // Toggle status
        if ($data->status == 'active') {
            $data->status = 'cancelled';
            $data->save();

            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
                'data' => $data,
            ]);
        } else {
            $data->status = 'active';
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data' => $data,
            ]);
        }
    }

    /**
     * Show the form for creating a new resource.
     * @return View
     */
    public function create()
    {
        return view('backend.layouts.membership.create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country' => 'required|exists:countries,id',
            'producer_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'plan_period_start' => 'required|date',
            'plan_period_end' => 'required|date',
        ]);

        DB::beginTransaction();
        try {

            $user = User::create([
                'name' => $request->name,
                'country_id' => $request->country,
                'producer_name' => $request->producer_name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $user->memberships()->create([
                'subscription_plan_price_id' => "created_by_admin",
                'plan_amount' => "0",
                'plan_currency' => "USD",
                'plan_interval' => "0",
                'plan_interval_count' => "0",
                'created' => date('Y-m-d'),
                'status' => "active",
                'method' => "stripe",
                'plan_period_start' => $request->plan_period_start,
                'plan_period_end' => $request->plan_period_end,
            ]);

            DB::commit();
            return redirect()->route('user.membership')->with('success', 'Membership created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            return redirect()->route('user.membership')->with('error', 'Failed to create membership.');
        }
    }
}
