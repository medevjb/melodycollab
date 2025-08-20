<?php

namespace App\Http\Controllers\Web\Producer;

use App\Http\Controllers\Controller;
use App\Models\Melody;
use App\Models\Pack;
use App\Models\User;
use App\Traits\MelodyFilterTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class ProducerController extends Controller
{
    use MelodyFilterTrait;
    /**
     * Show All My Producers
     * @retrun View
     */
    public function index(Request $request)
    {
        $topProducers = User::where('type', 'producer')
            ->whereHas('memberships', function ($query) {
                $query->where('status', 'active')
                    ->where('cancel', 0);
            })
            ->whereNotNull('country_id')
            ->where(function ($query) use ($request) {
                // Apply country filter if provided
                if ($request->has('country')) {
                    $query->where('country_id', $request->country);
                }

                // Apply search filter if provided
                if ($request->has('search') && $request->search != null) {
                    $search = '%' . $request->search . '%';
                    $query->orWhere('name', 'like', $search)
                        ->orWhere('producer_name', 'like', $search);
                }
            })
            ->take(10)
            ->get(); // Fetch the limited top producers

        $producers = User::where('type', 'producer')
            ->whereNotNull('country_id')
            ->where(function ($query) use ($request) {
                // Apply country filter if provided
                if ($request->has('country')) {
                    $query->where('country_id', $request->country);
                }

                // Apply search filter if provided
                if ($request->has('search') && $request->search != null) {
                    $search = '%' . $request->search . '%';
                    $query->orWhere('name', 'like', $search)
                        ->orWhere('producer_name', 'like', $search);
                }
            })
            ->paginate(20);

        return view('producer.layout.producer.index', compact('topProducers', 'producers'));
    }

    /**
     * Show Producer Profile
     * @param User $producer
     */
    public function profile(Request $request, $username)
    {
        if (auth()->user()->username == $username) {
            return redirect()->route('producer.my.profile');
        }
        $producer = User::where('username', $username)->where('type', 'producer')->with('followers')->first();

        if (!$producer) {
            return redirect()->back()->with('t-error', 'Producer Not Found');
        }

        // Packs
        $packs = Pack::where("user_id", $producer->id)->where('status', 'active')->get();
        // Base melody query
        $query = Melody::where('status', 'active')
            ->where('user_id', $producer->id)
            ->where('type', 'melody')
            ->with(['melodyGenres', 'melodyInstruments', 'melodyArtistTypes', 'user']) // Corrected relationship names
            ->latest();

        $addQuery = $this->applyMelodyFilters($request, $query);

        $melodies = $addQuery->paginate(10);

        // Prepare the data array to be passed to the view
        $data = [
            'melodies' => $melodies,
            'packs' => $packs,
            'producer' => $producer,
        ];
        if ($request->ajax() && count($melodies) > 0) {
            return response()->json([
                'html' => view('producer.partials.melody-list', ['melodies' => $melodies])->render(),
                'pagination' => $melodies->hasPages()
                ? view('producer.partials.pagination', ['melodies' => $melodies])->render()
                : '',
            ]);
        } else {
            return view('producer.layout.producer.show', compact('data'));
        }
    }
}
