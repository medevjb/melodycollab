<?php

namespace App\Http\Controllers\Web\Producer;

use App\Http\Controllers\Controller;
use App\Models\Melody;
use App\Models\Pack;
use App\Traits\MelodyFilterTrait;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    use MelodyFilterTrait;
    /**
     * Browse all melodies
     * @retrun View
     */
    public function index(Request $request)
    {
        $packs = Pack::where('name', 'like', '%' . request()->search . '%')
            ->orWhere('description', 'like', '%' . request()->search . '%')
            ->where('status', 'active')
            ->get();

        // Base melody query
        $query = Melody::where('status', 'active')
            ->where('name', 'like', '%' . request()->search . '%')
            ->where('type', 'melody')
            ->with(['melodyGenres', 'melodyInstruments', 'melodyArtistTypes', 'user']) // Corrected relationship names
            ->latest();

        $addQuery = $this->applyMelodyFilters($request, $query);

        $melodies = $addQuery->paginate(10);
        // Prepare the data array to be passed to the view
        $data = [
            'melodies' => $melodies,
            'packs' => $packs,
        ];

        if ($request->ajax() && count($melodies) > 0) {
            return response()->json([
                'html' => view('producer.partials.melody-list', ['melodies' => $melodies])->render(),
                'pagination' => $melodies->hasPages()
                ? view('producer.partials.pagination', ['melodies' => $melodies])->render()
                : '',
            ]);
        } else {
            return view('producer.layout.search', compact('data'));
        }
    }
}
