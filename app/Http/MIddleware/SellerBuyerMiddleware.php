<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Services\ProfilSellerService;
use Illuminate\Support\Facades\Auth;

class SellerBuyerMiddleware
{
    protected $profilSellerService;

    public function __construct()
    {
        $this->profilSellerService = new ProfilSellerService();
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Jika belum login
        if (!$user) {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cek profil seller
        $profil = $this->profilSellerService->find($user->id, 'user_id');

        // Belum daftar seller sama sekali
        if (!$profil) {
            return redirect()->route('buyer.seller.index')
                ->with('warning', 'Anda belum mendaftar sebagai seller.');
        }

        // Cek tahap berdasarkan flag
        switch ($profil->flag) {
            case 2:
                return redirect()->route('buyer.seller.verify')
                    ->with('warning', 'Lengkapi verifikasi diri terlebih dahulu.');
            case 3:
                return redirect()->route('buyer.seller.informasi_toko')
                    ->with('warning', 'Lengkapi informasi toko Anda terlebih dahulu.');
            case 4:
                return redirect()->route('buyer.seller.upload_produk')
                    ->with('warning', 'Silakan upload produk terlebih dahulu untuk mengaktifkan akun seller Anda.');
            case 0:
                return redirect()->route('buyer.seller.index')
                    ->with('warning', 'Akun seller Anda belum aktif.');
        }

        // Jika sudah aktif (flag = 1), lanjutkan
        return $next($request);
    }
}
