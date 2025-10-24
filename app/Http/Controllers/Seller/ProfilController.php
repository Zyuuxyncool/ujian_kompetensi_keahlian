<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Services\ProfilSellerService;
use App\Services\UserService;
use App\Services\DocumentService;
use Illuminate\Http\Request;

class ProfilController extends Controller
{
    protected $profilSellerService, $userService;

    public function __construct()
    {
        $this->profilSellerService = new ProfilSellerService();
        $this->userService = new UserService();
    }

    public function index()
    {
        $profil = $this->profilSellerService->find(auth()->user()->id, 'user_id');
        return view('seller.profil.index', compact('profil'));
    }

    public function update(Request $request)
    {
        $filename = DocumentService::save_file($request, 'file_foto', 'public/images/seller');
        if ($filename !== '') $request->merge(['photo' => $filename]);
        $profil = $this->profilSellerService->find(auth()->user()->id, 'user_id');
        $profil = $this->profilSellerService->update($request->all(), $profil->id);
        return redirect()->back()->with('success', 'Profil berhasil diupdate');
    }
}
