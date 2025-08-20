<?php

namespace App\Http\Controllers\Web\Backend;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $data = User::where('type', 'producer')
            ->with(['country', 'packs', 'orders.pack'])
            ->latest();

        // If google_user filter is passed, only fetch users with google_id
        if ($request->has('google_user') && $request->google_user == 'true') {
            $data = $data->whereNotNull('google_id');
        }

        // Filter by status (Paid/Free)
        if ($request->has('status')) {
            if ($request->status == 'paid') {
                $data = $data->whereHas('memberships', function ($query) {
                    $query->where([
                        'status' => 'active',
                        'cancel' => 0,
                    ]);
                });
            } elseif ($request->status == 'free') {
                $data = $data->whereDoesntHave('memberships', function ($query) {
                    $query->where([
                        'status' => 'active',
                        'cancel' => 0,
                    ]);
                });
            }
        }

        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()

                ->addColumn('producer_name', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill">
                                <h2 class="mb-0 small fw-normal bolder">' . ($data->producer_name ? $data->producer_name : $data->name) . '</h2>
                            </div>';
                })

                ->addColumn('country', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill">
                                <h2 class="mb-0 small fw-normal">' . ($data->country ? $data->country->name : ' ') . '</h2>
                            </div>';
                })

                ->addColumn('email', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill">
                                <h2 class="mb-0 small fw-normal bolder">' . ($data->email) . '</h2>
                            </div>';
                })

                ->addColumn('image', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill">
                                <img src="' . asset($data->avatar) . '" alt="avatar" class="img-fluid" style="max-height: 50px;">
                            </div>';
                })
                ->addColumn('join', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill">
                                <h2 class="mb-0 small fw-normal badge bg-primary">' . (Carbon::parse($data->created_at)->format('d-M-Y')) . '</h2>
                            </div>';
                })

                ->addColumn('status', function ($data) {
                    $class = $data->ifMembership() ? 'bg-success' : 'bg-danger';
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill">
                                <h2 class="mb-0 small fw-normal badge ' . $class . '">' . ($data->ifMembership() ? 'Paid' : 'Free') . '</h2>
                            </div>';
                })

                ->addColumn('TotalSales', function ($data) {
                    $totalSales = 0;

                    foreach ($data->packs as $pack) {
                        $totalSales += $pack->orders->sum('price');
                    }

                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill">
                                <h2 class="mb-0 small fw-normal bolder">' . number_format($totalSales, 2) . '</h2>
                            </div>';
                })

                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">                              
                              <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white" name="Delete">
                              <i class="bi bi-trash"></i>
                            </a>
                            </div>';
                })

                ->rawColumns(['producer_name', 'join', 'country', 'email', 'image', 'status', 'TotalSales', 'action'])
                ->make(true);
        }

        return view('backend.layouts.user.index');
    }

    public function destroy(int $id): JsonResponse
    {
        $faq = User::findOrFail($id);
        $faq->delete();
        return response()->json([
            't-success' => true,
            'message' => 'User Deleted successfully.',
        ]);
    }
}
