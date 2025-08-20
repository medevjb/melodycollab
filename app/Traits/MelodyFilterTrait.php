<?php

namespace App\Traits;

use Illuminate\Http\Request;

trait MelodyFilterTrait
{
    /**
     * Apply filters to the melody query.
     *
     * @param Request $request
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function applyMelodyFilters(Request $request, $query)
    {
        // Same filtering logic as the service example
        if($request->order == '' && 
        $request->filter_genre == '' && 
        $request->filter_instruments == '' && 
        $request->filter_artise_type == '' &&
        $request->selected_key == '' &&
        $request->exect_bpm == '') {
             return $query;   
        }
        
        // Popular
        if($request->filled('order')) {
            if($request->order == 'popular') {
                $query->orderBy('playes', 'desc');
            } elseif($request->order == 'recent') {
                $query->orderBy('created_at', 'desc');
            } elseif($request->order == 'random') {
                $query->inRandomOrder();
            }
        }

        

        // Apply genre filter
        if ($request->filled('filter_genre')) {
            $query->whereHas('melodyGenres', function ($q) use ($request) {
                $q->where('genre_id', $request->filter_genre); // Correct column to filter by genre
            });
        }

        // Apply instrument filter
        if ($request->filled('filter_instruments')) {
            $query->whereHas('melodyInstruments', function ($q) use ($request) {
                $q->where('instrument_id', $request->filter_instruments); // Filter by instrument
            });
        }

        // Apply artist type filter
        if ($request->filled('filter_artise_type')) {
            $query->whereHas('melodyArtistTypes', function ($q) use ($request) {
                $q->where('artist_type_id', $request->filter_artise_type); // Filter by artist type
            });
        }

        if ($request->filled('selected_key')) {
            $query->where('key', $request->selected_key);
        }
        if ($request->exect_bpm == "range" && $request->filled('bmp_range_min') && $request->filled('bmp_range_max')) {
            $query->whereBetween('bpm', [$request->bmp_range_min, $request->bmp_range_max]);
        }

        if ($request->exect_bpm == "exact" && $request->filled('exect_bpm_value')) {
            $query->where('bpm', $request->exect_bpm_value);
        }

        return $query;
    }
}
