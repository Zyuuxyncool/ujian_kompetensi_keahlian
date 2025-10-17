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

        // 1. TANGANI FILE FOTO
        $filename = DocumentService::save_file($request, 'file_foto', 'public/images/buyer');

        // 2. BERSIHKAN DATA INPUT
        // Buat array data yang aman untuk di-update.
        // Mengecualikan 'file_foto' (walaupun sudah ditangani), '_token', '_method', dan 'email' (karena ini untuk tabel User).
        $data_to_update = $request->except([
            'file_foto',
            '_token',
            '_method',
            'email' // Email akan di-update terpisah melalui UserService
        ]);

        // 3. TAMBAHKAN NAMA FOTO JIKA ADA
        if ($filename !== '') {
            $data_to_update['photo'] = $filename;
        }

        // 4. UPDATE PROFIL BUYER (Termasuk latitude & longitude yang dikirim dari form)
        $profil = $this->profilBuyerService->find(auth()->user()->id, 'user_id');

        // Memanggil Service: update($params, $id)
        $this->profilBuyerService->update($data_to_update, $profil->id);

        // 5. UPDATE DATA USER (Email)
        // Di sini kita update email yang ada di tabel 'users'.
        if ($request->has('email')) {
            // Asumsi: UserService::update($params, $id)
            $this->userService->update(['email' => $request->email], $profil->user_id);
        }

        return redirect()->back()->with('success', 'Profil berhasil diupdate');
    }
}
