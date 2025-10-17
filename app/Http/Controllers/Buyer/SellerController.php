<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SellerController extends Controller
{
    protected $userService;
    public function __construct()
    {
        $this->userService = new UserService();
    }

    public function index()
    {
        $user = Auth()->user();

        // Jika user sudah punya profil seller → arahkan ke dashboard seller
        if ($user->seller) {
            return redirect()->route('seller.dashboard.index');
        }

        // Jika belum punya profil seller → tampilkan halaman aktivasi seller
        return view('buyer.seller.index');
    }

    public function verify(Request $request)
    {
        return view('buyer.seller.verify');
    }
}
