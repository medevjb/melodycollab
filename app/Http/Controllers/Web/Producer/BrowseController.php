<?php

namespace App\Http\Controllers\Web\Producer;

use App\Http\Controllers\Controller;
use App\Models\Melody;
use App\Traits\MelodyFilterTrait;
use Illuminate\Http\Request;

class BrowseController extends Controller
{
    use MelodyFilterTrait;

    public function index(Request $request)
    {
        // Base melody query
        $query = Melody::where('status', 'active')
            ->where('type', 'melody')
            ->with(['melodyGenres', 'melodyInstruments', 'melodyArtistTypes', 'user']);

        // Apply Search if provided
        if ($request->has('search') && $request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($query) use ($request) {
                        $query->where('producer_name', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('melodyGenres', function ($query) use ($request) {
                        $query->where('title', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('melodyInstruments', function ($query) use ($request) {
                        $query->where('title', 'like', '%' . $request->search . '%');
                    })
                    ->orWhereHas('melodyArtistTypes', function ($query) use ($request) {
                        $query->where('title', 'like', '%' . $request->search . '%');
                    });
            });
            $query = $this->applyMelodyFilters($request, $query);
        } else {
            // Apply additional filters through the applyMelodyFilters function
            $query = $this->applyMelodyFilters($request, $query);
        }


        // Paginate the filtered results
        $melodies = $query->paginate(20);

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

        // Return full page view for non-AJAX requests
        return view('producer.layout.browse', compact('data'));
    }

}
