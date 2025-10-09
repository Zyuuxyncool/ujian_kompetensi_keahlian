<?php

namespace App\Http\Controllers\Shipper;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    /**
     * Display the shipper dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $user = auth()->user();
        $role = $user->akses->akses;

        if ($role !== 'Shipper') {
            abort(403, 'Unauthorized action.');
        }

        return view('shipper.dashboard.index');
    }
}