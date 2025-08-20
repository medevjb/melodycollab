<?php

namespace App\Http\Controllers\Web\Producer;

use Exception;
use App\Models\Pack;
use App\Models\User;
use App\Models\Email;
use App\Models\Genres;
use App\Models\Melody;
use App\Helpers\Helper;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\ProducerPaypal;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Crypt;
use App\Notifications\MailNotification;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class PackController extends Controller
{

    /**
     * Download Melody
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function download($id)
    {
        // Find the melody by its ID
        $melody = Melody::findOrFail($id);

        // Get the file path from the melody record
        $filePath = public_path($melody->file); // Assuming file is stored in the 'public' directory

        // Extract the file name
        $fileName = basename($melody->file);

        // Check if file exists before attempting to download
        if (file_exists($filePath)) {
            return response()->download($filePath, $fileName);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }

    /**
     * PLay Componen
     * @param $id
     * @return JsonResponse
     */
    public function getPlayingMelody($id): JsonResponse
    {
        $melody = Melody::findOrFail($id);
        if ($melody) {
            return response()->json([
                'success' => true,
                'data' => $melody,
                'message' => "Melody Get Successfull",
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => "Melody Not Found",
            ]);
        }
    }

    /**
     * Create page show
     * @return View
     */
    public function create()
    {
        $membership = auth()->user()->hasMembership();
        if ($membership == null) {
            return redirect()->route("pricing")->with("t-error", "Please Upgrade Your Membership");
        }
        $genrises = Genres::where('status', 'active')->get();
        return view('producer.layout.pack.create', compact('genrises'));
    }

    /**
     * Store Melody
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request)
    {
        $membership = auth()->user()->hasMembership();
        if ($membership == null) {
            return redirect()->route("pricing")->with("t-error", "Please Upgrade Your Membership");
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric|between:0,99999.9999',
            'file' => 'required|string',
            'zipfile' => 'required|string',
            'genres' => 'required|array',
            'genres.*' => 'required|numeric|exists:genres,id',
            'terms' => 'required|accepted',
            'promoUrl' => 'required|url',
            'demo_id' => 'required|array',
            'demo_id.*' => 'required|numeric|exists:melodies,id',
            'description' => 'required|string',
        ], [
            'required' => ':attribute is required', // General message for required fields
            'accepted' => 'You must accept the :attribute', // For terms field
            'genres.*.exists' => 'Selected genre is invalid', // Specific message for invalid genre IDs
            'demo_id.*.exists' => 'Selected demo is invalid', // Specific message for invalid demo IDs
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Validation Error",
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $pack = new Pack();
            $pack->user_id = auth()->user()->id;
            $pack->name = $request->name;
            $pack->thumbnail = $request->file;
            $pack->price = $request->price;
            $pack->file = $request->zipfile;
            $pack->promo_video_url = $request->promoUrl;
            $pack->description = $request->description;

            $data = [
                'melody' => $pack,
                'producer' => auth()->user(),
                'country' => User::where('id', auth()->user()->id)->with('country')->first()->country->name,
            ];
            $pdf = Pdf::loadView('pdf.melody', $data);
            $pdfFileName = Str::slug($pack->name) . time() . '.pdf';
            $pdfPath = 'uploads/pack-pdf/' . $pdfFileName;
            Storage::disk('public')->put($pdfPath, $pdf->output());
            $pack->pdf = $pdfPath;

            $pack->save();

            $pack->packGenrese()->attach($request->genres);

            Melody::whereIn('id', $request->demo_id)->update(['pack_id' => $pack->id]);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pack Created successfully',
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
        // Mail Notification start
        $authuser = User::find(auth()->user()->id);
        $message = Email::where('id', )->select('subject', 'content')->first();

        if ($message) {
            Log::info('Sending notification to user: ' . $authuser->email);
            $data = $authuser->notify(new MailNotification($message->subject, $message->content)); // Send the notification
            Log::info('Notification sent successfully.');
            Log::info($data);
        }
        // Mail Notification start
    }

    /**
     * Show Page
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function show($id)
    {
        $pack = Pack::findOrFail(Crypt::decrypt($id))->load(['melodies', 'packGenrese']);
        return view('producer.layout.pack.show', compact('pack'));
    }
    /**
     * Show Edit Page
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function edit($id)
    {
        $membership = auth()->user()->hasMembership();
        if ($membership == null) {
            return redirect()->route("pricing")->with("t-error", "Please Upgrade Your Membership");
        }
        $pack = Pack::findOrFail(Crypt::decrypt($id))->load(['melodies']);
        $genrises = Genres::where('status', 'active')->get();
        return view('producer.layout.pack.edit', compact('pack', 'genrises'));
    }

    /**
     * Store Melody
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request)
    {

        $membership = auth()->user()->hasMembership();
        if ($membership == null) {
            return redirect()->route("pricing")->with("t-error", "Please Upgrade Your Membership");
        }
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'price' => 'required|numeric|between:0,99999.9999',
            'file' => 'nullable|string',
            'zipfile' => 'nullable|string',
            'genres' => 'required|array',
            'genres.*' => 'required|numeric|exists:genres,id',
            'terms' => 'required|accepted',
            'promoUrl' => 'required|url',
            'demo_id' => 'nullable|array',
            'demo_id.*' => 'nullable|numeric|exists:melodies,id',
            'description' => 'required|string|max:500',
            'id' => 'required|numeric|exists:packs,id',
        ], [
            'required' => ':attribute is required', // General message for required fields
            'accepted' => 'You must accept the :attribute', // For terms field
            'genres.*.exists' => 'Selected genre is invalid', // Specific message for invalid genre IDs
            'demo_id.*.exists' => 'Selected demo is invalid', // Specific message for invalid demo IDs
        ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => "Validation Error",
                'errors' => $validator->errors(),
            ]);
        }

        DB::beginTransaction();
        try {
            $pack = Pack::findOrFail($request->id);
            $pack->user_id = auth()->user()->id;
            $pack->name = $request->name;
            if ($request->file) {
                $pack->thumbnail = $request->file;
            }
            if ($request->zipfile) {
                $pack->file = $request->zipfile;
            }
            $pack->price = $request->price;
            $pack->promo_video_url = $request->promoUrl;
            $pack->description = $request->description;

            if (Storage::disk('public')->exists($pack->pdf)) {
                // Delete the existing PDF file from storage
                Storage::disk('public')->delete($pack->pdf);
            }

            $data = [
                'melody' => $pack,
                'producer' => auth()->user(),
                'country' => User::where('id', auth()->user()->id)->with('country')->first()->country->name,
            ];
            $pdf = Pdf::loadView('pdf.melody', $data);
            $pdfFileName = Str::slug($pack->name) . time() . '.pdf';
            $pdfPath = 'uploads/pack-pdf/' . $pdfFileName;
            Storage::disk('public')->put($pdfPath, $pdf->output());
            $pack->pdf = $pdfPath;
            $pack->save();

            $pack->packGenrese()->sync($request->genres);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Pack Updated successfully',
            ]);
        } catch (Exception $exception) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Delete Melody
     * @param $id
     * @return JsonResponse
     */

    public function destroy($id): JsonResponse
    {
        $membership = auth()->user()->hasMembership();
        if ($membership == null) {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => "Please Upgrade Your Membership",
            ]);
        }

        $pack = Pack::findOrFail($id);
        if ($pack) {
            $pack->melodies()->delete();
            $pack->packGenrese()->delete();
            if (File::exists(public_path($pack->thumbnail))) {
                File::delete(public_path($pack->thumbnail));
            }
            if (File::exists(public_path($pack->file))) {
                File::delete(public_path($pack->file));
            }

            $pack->delete();
            return response()->json([
                'success' => true,
                'data' => $pack,
                'message' => "Pack Deleted Successfully",
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => "pack Not Found",
            ]);
        }
    }

    /**
     * Download Melody
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function downloadPack($id)
    {
        $pack = Pack::findOrFail(Crypt::decrypt($id));
        $filePath = public_path($pack->file);

        $fileName = basename($pack->file);
        if (file_exists($filePath)) {
            return response()->download($filePath, $fileName);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'File not found',
            ]);
        }
    }
}
