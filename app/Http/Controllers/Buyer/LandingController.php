<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;

class LandingController extends Controller
{
    public function index()
    {
        // $user = auth()->user();
        // dd($user->buyer);
        return view('buyer.landing.index');
    }
}
