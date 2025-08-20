<?php

namespace App\Http\Controllers\Web\Backend\Packs;

use App\Models\Pack;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PacksController extends Controller
{

    public function index(Request $request)
    {
        $data = Pack::with('user')->latest();
        // dd($data);
        if ($request->ajax()) {


            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('user_name', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill">
                                <h2 class="mb-0 small fw-normal bolder">' . ($data->user->producer_name) . '</h2>
                            </div>';
                })
                ->addColumn('pack_name', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill ">
                                <h2 class="text-black mb-0 small fw-normal">' . $data->name . '</h2>
                            </div>';
                })
                ->addColumn('thumbnail', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill">
                                <img src="' . asset($data->thumbnail) . '" alt="Thumbnail" class="img-fluid" style="max-height: 50px;">
                            </div>';
                })
                ->addColumn('price', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill ">
                                <h2 class="text-black mb-0 small fw-normal">' . $data->price . '</h2>
                            </div>';
                })
                /* ->addColumn('file', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill ">
                                <h2 class="text-black mb-0 small fw-normal">' . $data->file . '</h2>
                            </div>';
                }) */
                ->addColumn('file', function ($data) {
                    if (!empty($data->file) && file_exists(public_path($data->file))) {
                        return '<div class="audio-container align-items-center">
                                    <a href="' . route('download.file', $data->id) . '" class="download-link">
                                        <i class="bi bi-cloud-download text-primary h3"></i>
                                    </a>                               
                                </div>';
                    } else {
                        return '<div class="audio-container">
                                    <a href="javascript:void(0);" onclick="fileNotExist()" class="download-link">
                                        <i class="bi bi-cloud-download text-muted h3"></i>
                                    </a>
                                </div>';
                    }
                }) 

                /* ->addColumn('promo_video_url', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill">
                                <h2 class="text-black mb-0 small fw-normal">' . $data->promo_video_url . '</h2>
                            </div>';
                }) */


                /* ->addColumn('status', function ($data) {
                    $checked = $data->status == 'active' ? 'checked' : '';
                    return '<label class="switch">
                                <input type="checkbox" ' . $checked . ' onclick="toggleStatus(' . $data->id . ')">
                                <span class="slider round"></span>
                            </label>';
                }) */

                ->addColumn('status', function ($data) {
                    $status = ' <div class="form-check form-switch">';
                    $status .= ' <input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status"';
                    if ($data->status == "active") {
                        $status .= "checked";
                    }
                    $status .= '><label for="customSwitch' . $data->id . '" class="form-check-label" for="customSwitch"></label></div>';

                    return $status;
                })




                ->rawColumns(['user_name', 'pack_name', 'thumbnail', 'price', 'file', 'promo_video_url','status'])
                ->make(true);
        }
        return view('backend.layouts.packs.index');
    }

     
    //toggle status
    public function toggleStatus(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $data = Pack::findOrFail($id);

        // Toggle status
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

     //for pack downloading
    public function downloadFile($id)
    {
        // Assuming the file path is stored in the 'file' column
        $data = pack::findOrFail($id); 
        $filePath = public_path($data->file); 

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json(['error' => 'File not exist'], 404);
        }
    }

     //toggle status for membership
     public function memtoggleStatus(Request $request)
     {
         $Membership = Membership::find($request->id);
 
         if ($Membership) {
             $Membership->status = $Membership->status == 'active' ? 'inactive' : 'active';
             $Membership->save();
 
             return response()->json(['success' => true]);
         }
 
         return response()->json(['success' => false]);
     }
}
