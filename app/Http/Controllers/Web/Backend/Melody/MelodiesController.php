<?php

namespace App\Http\Controllers\Web\Backend\Melody;

use App\Models\Melody;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Yajra\DataTables\Facades\DataTables;

class MelodiesController extends Controller
{

    public function index(Request $request)
    {
        $data = Melody::where('type', 'melody')->with(['user'])->latest();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('producer_name', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill">
                                <h2 class="mb-0 small fw-normal bolder">' . ($data->user->producer_name) . '</h2>
                            </div>';
                })
                ->addColumn('melody', function ($data) {
                    $name = $data->name;
                    if (strlen($name) > 20) {
                        $name = substr($name, 0, 20) . '...';
                    }
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill ">
                                <h2 class="text-black mb-0 small fw-normal">' . $name . '</h2>
                            </div>';
                })
                ->addColumn('thumbnail', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill">
                                <img src="' . asset($data->thumbnail) . '" alt="Thumbnail" class="img-fluid" style="max-height: 50px;">
                            </div>';
                })
                ->addColumn('file', function ($data) {
                    if (!empty($data->file) && file_exists(public_path($data->file))) {
                        return '<div class="audio-container">
                                    <a href="' . route('melody.download.file', ['id' => $data->id]) . '" class="download-link">
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


                ->addColumn('bpm', function ($data) {
                    if ($data->bpm) {
                        return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-info">
                                    <h2 class="text-white mb-0 small fw-normal">' . $data->bpm . '</h2>
                                </div>';
                    } else {
                        return ' ';
                    }
                })

                ->addColumn('key', function ($data) {
                    if ($data->key) {
                        return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-warning">
                                    <h2 class="text-black mb-0 small fw-normal">' . $data->key . '</h2>
                                </div>';
                    } else {
                        return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill">
                                    <h2 class="mb-0 small fw-normal"></h2>
                                </div>';
                    }
                })


                ->addColumn('split', function ($data) {
                    if ($data->split) {
                        return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill bg-primary">
                                <h2 class="text-white mb-0 small fw-normal">' . $data->split . '</h2>
                            </div>';
                    } else {
                        return ' ';
                    }
                })
                ->addColumn('type', function ($data) {
                    return '<div class="d-inline-flex align-items-center px-3 py-1 rounded-pill">
                                    <h2 class="text-black mb-0 small fw-normal">' . $data->type . '</h2>
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



                ->rawColumns(['producer_name', 'melody', 'thumbnail', 'file', 'bpm', 'key', 'split', 'type', 'status'])
                ->make(true);
        }
        return view('backend.layouts.melody.index');
    }


    //toggle status
    public function status(Request $request): JsonResponse
    {
        $id = $request->input('id');
        $data = Melody::findOrFail($id);

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


    //for downloading
    public function melodydownloadFile($id)
    {
        // Assuming the file path is stored in the 'file' column
        $data = Melody::findOrFail($id); // Replace YourModel with your actual model
        $filePath = public_path($data->file); // Update with the correct file path

        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            return response()->json(['error' => 'File not exist'], 404);
        }
    }
}
