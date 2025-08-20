<?php

namespace App\Http\Controllers\Web\Backend;

use Exception;
use App\Models\Instrument;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class InstrumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse       
    {
        if ($request->ajax()) {
            $data = Instrument::orderBy('order', 'asc');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($data) {
                    return "<span class='bg-primary badge fs-5'>$data->title</span>";
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
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                              <button onclick="ShowUpdateModal(' . $data->id . ')" type="button" class="btn btn-primary text-white" title="Edit">
                              <i class="bi bi-pencil"></i>
                              </button>
                              <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" type="button" class="btn btn-danger text-white" title="Delete">
                              <i class="bi bi-trash"></i>
                            </a>
                            </div>';
                })
                ->rawColumns(['title', 'status', 'action'])
                ->make();
        }
        return view('backend.layouts.instrument.index');
    }

    /**
     * For drag and drop ordaring
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function reorder( Request $request ) {
        $order = $request->input( 'order' );

        foreach ( $order as $index => $item ) {
            // Find the post by ID and update its position
            Instrument::where( 'id', $item['id'] )->update( ['order' => $index + 1] );
        }

        return response()->json( ['status' => 'success'] );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function createOrUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:100',
            'id' => 'nullable|',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Validation Error",
                'errors' => $validator->errors()->first(),
            ]);
        }

        try {

            Instrument::updateOrCreate(
                [
                    "id" => $request->id,
                ],
                [
                    'title' => $request->title,
                ]
            );

            return response()->json([
                'success' => true,
                'message' => "Instrument Store Successfull",
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => "Something Went Wrong",
                'errors' => $e->getMessage(),
            ]);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return View
     */
    public function getInstrument(int $id): JsonResponse
    {
        $Instrument = Instrument::findOrFail($id);
        return response()->json([
            'success' => true,
            'data' => $Instrument,
            'message' => "Instrument Get Successfull",
        ]);
    }

    /**
     * Change the status of the specified resource.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse
    {
        $data = Instrument::findOrFail($id);
        if ($data->status == 'active') {
            $data->status = 'inactive';
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
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse
    {
        $faq = Instrument::findOrFail($id);
        $faq->delete();
        return response()->json([
            't-success' => true,
            'message' => 'Deleted successfully.',
        ]);
    }
}
