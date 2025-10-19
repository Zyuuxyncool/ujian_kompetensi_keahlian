<?php

namespace App\Http\Controllers\Buyer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\ProfilBuyerService;
use App\Services\DocumentService;
use App\Services\UserService;

class ProfilController extends Controller
{

    protected $profilBuyerService, $userService;
    public function __construct()

    {
        $this->profilBuyerService = new ProfilBuyerService();
        $this->userService = new UserService();
    }

    public function index()

    {
        $profil = $this->profilBuyerService->find(auth()->user()->id, 'user_id');
        return view('buyer.profil.index', compact('profil'));
    }



    public function update(Request $request)
    {
        $filename = DocumentService::save_file($request, 'file_foto', 'public/images/buyer');
        if ($filename !== '') $request->merge(['photo' => $filename]);
        $profil = $this->profilBuyerService->find(auth()->user()->id, 'user_id');
        $profil = $this->profilBuyerService->update($request->all(), $profil->id);
        // $user = $this->userService->update($request->all(), $profil->user_id);
        return redirect()->back()->with('success', 'Profil berhasil diupdate');
    }
}
