<?php

namespace App\Http\Controllers\Web\Producer;

use App\Http\Controllers\Controller;
use App\Models\Pack;
use Illuminate\Http\Request;

class MarketPlaceController extends Controller
{
    /**
     * Show Marketplace Page
     * @return View
     */
    public function index(Request $request)
    {
        $topPacks = Pack::orderBy('created_at', 'desc')->with('user', 'melodiesFirst')->take(10)->get(['id', 'name', 'thumbnail', 'price', 'status', 'user_id']);
        $packs = Pack::orderBy('created_at', 'desc')
            ->with('user','melodiesFirst','packGenrese');

        // Search Impliment
        if($request->filled('search')) {
            $packs = $packs
            ->where('name', 'like', '%' . $request->search . '%')
            ->orWhereHas('user', function ($query) use ($request) {
                $query->where('producer_name', 'like', '%' . $request->search . '%');
            })
            ->orWhereHas('packGenrese', function ($query) use ($request) {
                $query->where('title', 'like', '%' . $request->search . '%');
            });
        }
        $packs = $packs->paginate(10);

        return view('producer.layout.marketplace.index', compact('topPacks', 'packs'));
    }
}
