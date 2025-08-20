<?php

namespace App\Http\Controllers\Web\Producer;

use App\Models\Melody;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PackDemoController extends Controller
{

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'zipfile' => $request->id ? 'nullable|string' : 'required|string',
        ]);

        $validator = Validator::make($request->all(), [
            'file' => [
                'required',
                'file',
                'mimes:' . ($request->type == '.zip' ? 'zip' : 'mp3,wav,aac,ogg,flac,m4a,wma,aiff,alac,opus,amr'),
                'max:200048',
            ],
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first(),
            ]);
        }

        if ($request->hasFile('file')) {
            $zip = $request->file('file');

            // Generate a unique file name to avoid conflicts
            $zipName = Str::slug($zip->getClientOriginalName() . '.') . '.' . $zip->getClientOriginalExtension();

            // Store the file in the storage/app/public/uploads directory
            $path = $zip->storeAs('uploads/melody-audio', $zipName, 'public');

           
            $demo = new Melody();
            $demo->name = str_replace('-', ' ', $zipName);
            $demo->user_id = auth()->user()->id;
            $demo->thumbnail = '/uploads/melody/thumbnail/1729502996.png';
            $demo->file = $path;
            $demo->type = 'demo';
            $demo->save();

            return response()->json([
                'success' => true,
                'message' => "Demo added successfully",
                'data' => $demo,
                'user' => auth()->user(),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => "Demo not added",
            ]);
        }

    }

    public function getPlayingDemo($id)
    {
        $pack = Melody::findOrFail($id);
        if ($pack) {
            return response()->json([
                'success' => true,
                'data' => $pack,
                'message' => "Pack Demo Get Successfull",
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => "Pack Demo Not Found",
            ]);
        }
    }

    /**
     * Delete Demo
     * @param $id
     * @return JsonResponse
     */
    public function destroy($id): JsonResponse
    {
        $demo = Melody::findOrFail($id);
        if ($demo) {
            if (File::exists(public_path($demo->thumbnail))) {
                File::delete(public_path($demo->thumbnail));
            }
            if (File::exists(public_path($demo->file))) {
                File::delete(public_path($demo->file));
            }
            $demo->delete();
            return response()->json([
                'success' => true,
                'data' => $demo,
                'message' => "Pack Demo Deleted Successfully",
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => "Pack Demo Not Found",
            ]);
        }
    }

}
