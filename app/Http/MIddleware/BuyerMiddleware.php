<?php

namespace App\Http\Middleware;

use App\Services\MenuService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class BuyerMiddleware
{

    public function handle(Request $request, Closure $next): Response
    {
        $user = auth()->user() ?? [];
        if ($request->method() === 'GET') {
            $menuService = new MenuService();
            $menus = $menuService->list_menu('Nusantara');

            $active_role = session('active_role', $user->akses->akses ?? '');
            if (!empty($user->buyer)) $user_menus = $menuService->list_menu('Buyer');
            else if (!empty($user->seller)) $user_menus = $menuService->list_menu('Seller');
            else $user_menus = $menuService->list_menu($active_role);

            view()->share(['menus' => $menus, 'user_menus' => $user_menus]);
            $current_route = $request->route()->getName();
            $current_route_params = $request->query();
            view()->share($menuService::current_menu($menus, $current_route, 'Buyer', $current_route_params));
        }
        return $next($request);
    }
}
