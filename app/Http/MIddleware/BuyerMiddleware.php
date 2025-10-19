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

        if ($request->isMethod('get')) {
            $menuService = new MenuService();
            $currentRoute = $request->route()->getName();

            $currentRouteParams = $request->query() ?? [];
            if (!is_array($currentRouteParams)) {
                $currentRouteParams = [];
            }

            if (str_starts_with($currentRoute, 'seller.')) {
                $activeRole = 'Seller';
                $menusForView = $menuService->list_menu('Seller');
                $userMenus = $menusForView;
            } else {
                $activeRole = session('active_role', $user->akses->akses ?? '');
                $menusForView = $menuService->list_menu('Buyer');

                if (!empty($user->seller)) {
                    $menusForView = array_merge($menusForView, $menuService->list_menu('Seller'));
                }

                $userMenus = $menuService->list_menu('Buyer');
            }

            view()->share([
                'menus' => $menusForView,
                'user_menus' => $userMenus,
                'active_role' => $activeRole
            ]);

            view()->share(
                $menuService::current_menu($menusForView, $currentRoute, $activeRole, $currentRouteParams)
            );
        }

        return $next($request);
    }
}
