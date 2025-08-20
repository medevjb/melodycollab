<?php

namespace App\Http\Controllers\Web\Producer;

use Exception;
use FFMpeg\FFMpeg;
use App\Models\Pack;
use App\Models\User;
use App\Models\Genres;
use App\Models\Melody;
use App\Helpers\Helper;
use App\Models\ArtistType;
use App\Models\Instrument;
use App\Models\MyDownloads;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Traits\MelodyFilterTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class MelodyController extends Controller
{
    use MelodyFilterTrait;

    /**
     * Show All My Items
     * @retrun View
     */
    public function index(Request $request)
    {
        // Fetch My Packs
        $packs = Pack::where('user_id', auth()->user()->id)
            ->where('status', 'active')
            ->with(['user'])
            ->get();

        // Base melody query
        $query = Melody::where('user_id', auth()->user()->id)
            ->where('status', operator: 'active')
            ->where('type', 'melody')
            ->with(['melodyGenres', 'melodyInstruments', 'melodyArtistTypes'])
            ->latest();

        // Apply filters
        $query = $this->applyMelodyFilters($request, $query);

        // Get the filtered or unfiltered melodies
        $melodies = $query->paginate(10);

        // Prepare the data array to be passed to the view
        $data = [
            'melodies' => $melodies,
            'packs' => $packs,
        ];

        // If the request is an AJAX call, return a JSON response with the partial view
        if ($request->ajax()) {
            return response()->json([
                'html' => view('producer.partials.melody-list', ['melodies' => $melodies])->render(),
                'pagination' => $melodies->hasPages()
                ? view('producer.partials.pagination', ['melodies' => $melodies])->render()
                : '',
            ]);
        }
        return view('producer.layout.melody.index', compact('data'));
    }

    /**
     * Download Melody
     * @param $id
     * @return \Illuminate\Http\Response
     */
    public function download(Request $request, $id)
    {
        if ($request->ajax()) {
            $melody = Melody::findOrFail($id)->load(['user']);

            $melody->increment('downloads');

            return response()->json([
                'success' => true,
                'data' => $melody,
                'message' => "Melody Get Successfull",
            ]);
        }
        $melody = Melody::findOrFail($id);
        $filePath = public_path($melody->original_file ?? $melody->file);

        $fileName = basename($melody->original_file ?? $melody->file);
        if (file_exists($filePath)) {

            MyDownloads::create([
                'user_id' => auth()->user()->id,
                'melody_id' => $melody->id,
                'type' => 'melody',
            ]);


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
    public function getPlayingMelody($id)
    {
        $melody = Melody::findOrFail($id)->load(['user', 'pack']);
        if ($melody) {
            $melody->increment('playes');
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
        if (!auth()->user()->hasMembership()) {
            $createdMelody = Melody::where('user_id', auth()->user()->id)->where('status', 'active')->where('type', 'melody')->get();
            if (count($createdMelody) >= 5) {
                return redirect()->back()->with('t-error', 'You can only upload 5 melodies with the free plan. Please upgrade to upload unlimited
 melodies');
            }
        }

        $genrises = Genres::where('status', 'active')->get();
        $instruments = Instrument::where('status', 'active')->get();
        $artiseTypes = ArtistType::where('status', 'active')->get();
        return view('producer.layout.melody.create', compact('genrises', 'instruments', 'artiseTypes'));
    }

    /**
     * Upload Zip File
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function uploadZip(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'file' => [
                'required',
                'file',
                'mimes:zip,mp3,wav,aac,ogg,flac,m4a,wma,aiff,alac,opus,amr', // Allowed audio formats
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
            $file = $request->file('file');
            $originalNameWithoutExtension = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
            $sluggedName = Str::slug($originalNameWithoutExtension);

            // Check if the uploaded file is a ZIP file
            if ($file->extension() == 'zip') {
                $zipName = $sluggedName . '-' . time() . '.zip';
                $path = $file->storeAs('uploads/melody-audio', $zipName, 'public');

                return response()->json([
                    'success' => true,
                    'message' => 'ZIP file uploaded successfully',
                    'file_name' => str_replace('-', ' ', $originalNameWithoutExtension),
                    'url' => Storage::url($path),
                    'type' => 'zip',
                ]);
            }
            // Check if the uploaded file is a .wav file and needs to be converted to .mp3
            elseif ($file->extension() == 'wav') {
                // Define paths for ffmpeg and ffprobe binaries

                $ffmpegPath = env('FFMPEG_PATH','/opt/homebrew/bin/ffmpeg');
                $ffprobePath = env('FFPROBE_PATH','/opt/homebrew/bin/ffprobe');

                $ffmpeg = FFMpeg::create([
                    'ffmpeg.binaries' => $ffmpegPath,
                    'ffprobe.binaries' => $ffprobePath,
                    'timeout' => 3600, // Optional: adjust timeout
                ]);

                // Store the original .wav file
                $relativePath = "uploads/melody-audio/original/{$sluggedName}-" . time() . ".wav";
                $audioPath = $file->storeAs('uploads/melody-audio/original', "{$sluggedName}-".time().".wav", 'public'); // Store the file
                $originalFilePath = Storage::disk('public')->path($relativePath); // Get the server path

                // Define the converted MP3 file path
                $convertedName = "{$sluggedName}-" . time() . ".mp3";
                $convertedPath = "uploads/melody-audio/{$convertedName}";

                // Open the .wav file and convert it to .mp3
                $audio = $ffmpeg->open($originalFilePath);
                $audio->save(new \FFMpeg\Format\Audio\Mp3(), Storage::disk('public')->path($convertedPath));

                // Return the response with the correct file name and extension
                return response()->json([
                    'success' => true,
                    'message' => 'File uploaded and converted to MP3 successfully',
                    'file_name' => str_replace('-', ' ', $originalNameWithoutExtension),
                    'url' => Storage::url($convertedPath), // Publicly accessible URL
                    'original_url' => Storage::url($relativePath), // Publicly accessible URL
                    'type' => 'audio',
                ]);
            }
            // For other audio file types, upload them directly without conversion
            else {
                $sluggedName = Str::slug($originalNameWithoutExtension) . time() . '.' . $file->extension();
                $audioPath = $file->storeAs('uploads/melody-audio', "{$sluggedName}.{$file->extension()}", 'public');

                return response()->json([
                    'success' => true,
                    'message' => 'Audio file uploaded successfully without conversion',
                    'file_name' => str_replace('-', ' ', $originalNameWithoutExtension),
                    'url' => Storage::url($audioPath),
                    'type' => 'audio',
                ]);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'No file was uploaded',
        ]);
    }

    /**
     * Upload Thumbnail
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function uploadThumbnail(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'image' => 'required|image|mimes:jpeg,png,jpg|max:4048',
            ]);
            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $validator->errors()->first(),
                ]);
            }

            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $url = Helper::fileUpload($image, 'melody/thumbnail', time());
            }

            return response()->json([
                'success' => true,
                'message' => 'Thumbnail uploaded successfully',
                'url' => asset($url),
            ]);
        } catch (Exception $exception) {
            return response()->json([
                'success' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Store Melody
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'file' => 'required|string',
            'zipfile' => 'required|string|',
            'original_url' => $request->zipfile !== null ? 'nullable|string' : 'required|string',
            'bpm' => 'required|numeric',
            'genres' => 'required|array',
            'genres.*' => 'required|numeric|exists:genres,id',
            'instruments' => 'required|array',
            'instruments.*' => 'required|numeric|exists:instruments,id',
            'artist_type' => 'required|array',
            'artist_type.*' => 'required|numeric|exists:artist_types,id',
            'selected_key' => 'required|string',
            'split_percentage' => 'required|numeric',
            'terms' => 'required|accepted',
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
            $melody = new Melody();
            $melody->user_id = auth()->user()->id;
            $melody->name = $request->name;
            $melody->thumbnail = $request->file;
            $melody->file = $request->zipfile;
            $melody->original_file = $request->original_url;
            $melody->bpm = $request->bpm;
            $melody->split = $request->split_percentage;
            $melody->key = $request->selected_key;
            $data = [
                'melody' => $melody,
                'producer' => auth()->user(),
                'country' => User::where('id', auth()->user()->id)->with('country')->first()->country?->name,
            ];
            $pdf = Pdf::loadView('pdf.melody', $data);
            $pdfFileName = Str::slug($melody->name) . time() . '.pdf';
            $pdfPath = 'uploads/melody-pdf/' . $pdfFileName;
            Storage::disk('public')->put($pdfPath, $pdf->output());
            $melody->pdf = $pdfPath;
            $melody->save();

            $melody->melodyGenres()->attach($request->genres);
            $melody->melodyInstruments()->attach($request->instruments);
            $melody->melodyArtistTypes()->attach($request->artist_type);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Melody Created successfully',
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
     * Show Edit Page
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */

    public function edit($id)
    {
        $melody = Melody::findOrFail(Crypt::decrypt($id))->load(['melodyGenres', 'melodyInstruments', 'melodyArtistTypes']);
        $genrises = Genres::where('status', 'active')->get();
        $instruments = Instrument::where('status', 'active')->get();
        $artiseTypes = ArtistType::where('status', 'active')->get();
        $data = [
            'melody' => $melody,
            'genrises' => $genrises,
            'instruments' => $instruments,
            'artiseTypes' => $artiseTypes,
        ];
        return view('producer.layout.melody.edit', compact('data'));
    }

    /**
     * Store Melody
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'file' => 'nullable|string',
            'zipfile' => 'nullable|string',
            'bpm' => 'required|numeric',
            'genres' => 'required|array',
            'genres.*' => 'required|numeric|exists:genres,id',
            'instruments' => 'required|array',
            'instruments.*' => 'required|numeric|exists:instruments,id',
            'artist_type' => 'required|array',
            'artist_type.*' => 'required|numeric|exists:artist_types,id',
            'selected_key' => 'nullable|string',
            'split_percentage' => 'required|numeric',
            'terms' => 'required|accepted',
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
            $melody = Melody::where('id', Crypt::decrypt($request->id))->first();
            $melody->user_id = auth()->user()->id;
            $melody->name = $request->name;
            if ($request->file) {
                $melody->thumbnail = $request->file;
            }
            if ($request->zipfile) {
                $melody->file = $request->zipfile;
            }
            $melody->bpm = $request->bpm;
            $melody->split = $request->split_percentage;
            if ($request->selected_key) {
                $melody->key = $request->selected_key;
            }

            if (Storage::disk('public')->exists($melody->pdf)) {
                // Delete the existing PDF file from storage
                Storage::disk('public')->delete($melody->pdf);
            }

            $data = [
                'melody' => $melody,
                'producer' => auth()->user(),
                'country' => User::where('id', auth()->user()->id)->with('country')->first()->country->name,
            ];
            $pdf = Pdf::loadView('pdf.melody', $data);
            $pdfFileName = Str::slug($melody->name) . time() . '.pdf';
            $pdfPath = 'uploads/melody-pdf/' . $pdfFileName;
            Storage::disk('public')->put($pdfPath, $pdf->output());
            $melody->pdf = $pdfPath;

            $melody->save();

            $melody->melodyGenres()->sync($request->genres);
            $melody->melodyInstruments()->sync($request->instruments);
            $melody->melodyArtistTypes()->sync($request->artist_type);

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Melody uploaded successfully',
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
        $melody = Melody::findOrFail($id);
        if ($melody) {
            $melody->delete();
            return response()->json([
                'success' => true,
                'data' => $melody,
                'message' => "Melody Deleted Successfully",
            ]);
        } else {
            return response()->json([
                'success' => false,
                'data' => [],
                'message' => "Melody Not Found",
            ]);
        }
    }
}
