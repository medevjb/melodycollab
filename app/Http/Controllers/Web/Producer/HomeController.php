<?php

namespace App\Http\Controllers\Web\Producer;

use App\Http\Controllers\Controller;
use App\Models\Favourite;
use App\Models\Follower;
use App\Models\Melody;
use App\Models\MyDownloads;
use App\Models\Pack;
use App\Traits\MelodyFilterTrait;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller
{
    use MelodyFilterTrait;
    /**
     * Get Revenue data
     * @param Request $request
     * @return JsonResponse
     */
    public function getRevenue(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'data' => 'required|in:today,week,month,ytd',
        ]);

        if ($validation->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validation->errors()->first(),
            ]);
        }

        $revinue = auth()->user()->packs()
            ->withSum(['orders' => function ($query) {
                $query->whereDate('created_at', today());
            }], 'price');
        $followers = Follower::where('user_id', auth()->user()->id);
        $playes = Melody::where('user_id', auth()->user()->id);
        $totalDownloads = Melody::where('user_id', auth()->user()->id);


        if ($request->data == 'week') {
            $revinue = $revinue->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            $followers = $followers->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            $playes = $playes->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
            $totalDownloads = $totalDownloads->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
        } elseif ($request->data == 'month') {
            $revinue = $revinue->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
            $followers = $followers->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
            $playes = $playes->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
            $totalDownloads = $totalDownloads->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()]);
        }elseif ($request->data == 'ytd') {
            $revinue = $revinue->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()]);
            $followers = $followers->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()]);
            $playes = $playes->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()]);
            $totalDownloads = $totalDownloads->whereBetween('created_at', [now()->startOfYear(), now()->endOfYear()]);
        }

        return response()->json([
            'success' => true,
            'data' => [
                'revenue' => $revinue->value('orders_sum_price'),
                'followers' => $followers->count(),
                'playes' => $playes->sum('playes'),
                'downloads' => $totalDownloads->sum('downloads'),
            ],
        ]);
    }

    /**
     * Show My Downloads
     * @return View
     */
    public function myDownloads(Request $request)
    {
        $downloadedMelody = MyDownloads::where('user_id', auth()->user()->id)
            ->where('type', 'melody')
            ->get()
            ->pluck('melody_id')
            ->toArray();

        $downloadedPack = MyDownloads::where('user_id', auth()->user()->id)
            ->where('type', 'pack')
            ->get()
            ->pluck('pack_id')
            ->toArray();
        $pack = Pack::whereIn('id', $downloadedPack)
            ->where('status', 'active')
            ->get();

        // Base melody query
        $query = Melody::where('status', 'active')
            ->where('type', 'melody')
            ->whereIn('id', $downloadedMelody)
            ->with(['melodyGenres', 'melodyInstruments', 'melodyArtistTypes', 'user'])
            ->latest();

        // Apply additional filters through the applyMelodyFilters function
        $query = $this->applyMelodyFilters($request, $query);

        // Paginate the filtered results
        $melodies = $query->paginate(10);

        // Prepare the data array to be passed to the view
        $data = [
            'melodies' => $melodies,
            'packs' => $pack,
        ];

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'html' => view('producer.partials.melody-list', ['melodies' => $melodies])->render(),
                'pagination' => $melodies->hasPages()
                ? view('producer.partials.pagination', ['melodies' => $melodies])->render()
                : '',
            ]);
        }

        return view('producer.layout.profile.my-downloads', compact('data'));
    }
    /**
     * Show My Downloads
     * @return View
     */
    public function recentDownloads(Request $request): View
    {
        // Get last 5 dayes downloaded packs
        $downloadedPack = MyDownloads::where('user_id', auth()->user()->id)
            ->where('type', 'pack')
            ->whereDate('created_at', '>=', now()->subDays(5))
            ->get()
            ->pluck('pack_id')
            ->toArray();
        $packs = Pack::whereIn('id', $downloadedPack)
            ->where('status', 'active')
            ->get();

        return view('producer.layout.profile.recent-downloads', compact('packs'));
    }

    /**
     * Show My Favorites
     * @return View
     */
    public function myFavorites(Request $request): View
    {
        $myFvrt = Favourite::where('user_id', auth()->user()->id)
            ->get()
            ->pluck('melody_id')
            ->toArray();
        // Base melody query
        $query = Melody::where('status', 'active')
            ->whereIn('id', $myFvrt)
            ->with(['melodyGenres', 'melodyInstruments', 'melodyArtistTypes', 'user'])
            ->latest();

        // Apply additional filters through the applyMelodyFilters function
        $query = $this->applyMelodyFilters($request, $query);

        // Paginate the filtered results
        $melodies = $query->paginate(10);

        // Prepare the data array to be passed to the view
        $data = [
            'melodies' => $melodies,
        ];

        // Handle AJAX requests
        if ($request->ajax()) {
            return response()->json([
                'html' => view('producer.partials.melody-list', ['melodies' => $melodies])->render(),
                'pagination' => $melodies->hasPages()
                ? view('producer.partials.pagination', ['melodies' => $melodies])->render()
                : '',
            ]);
        }
        return view('producer.layout.profile.my-favorite', compact('data'));
    }

    /**
     * Add To Favorites
     * @param $id
     * @return JsonResponse
     */
    public function addToFavorite($id): JsonResponse
    {
        $melody = Melody::findOrFail($id);
        if ($melody) {
            $isFvrt = Favourite::where('user_id', auth()->user()->id)
                ->where('melody_id', $melody->id)
                ->first();
            if ($isFvrt) {
                $isFvrt->delete();
                return response()->json([
                    'success' => true,
                    'data' => $melody,
                    'message' => "Melody Removed From Favorites",
                ]);
            }
            Favourite::create([
                'user_id' => auth()->user()->id,
                'melody_id' => $melody->id,
            ]);
            return response()->json([
                'success' => true,
                'data' => $melody,
                'message' => "Melody Added To Favorites",
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
