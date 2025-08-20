<?php

namespace App\Http\Controllers\Web\Producer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     * @retrun View
     */
    public function index()
    {
        return view('producer.layout.checkout');
    }
}
