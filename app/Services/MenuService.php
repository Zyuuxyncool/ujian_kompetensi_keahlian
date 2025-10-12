<?php

namespace App\Services;

use App\Models\UserAkses;

class MenuService
{
    protected static array $admin = [
        ['route' => 'admin.dashboard', 'caption' => 'Dashboard'],
        ['route' => 'admin.user.index', 'caption' => 'User Program'],
        'data_master' => ['route' => '#', 'caption' => 'Data Master', 'sub_menus' => [
            ['route' => 'admin.kategori.index', 'caption' => 'Kategori'],
            ['route' => 'admin.sub_kategori.index', 'caption' => 'Sub Kategori'],
            ['route' => 'admin.brand.index', 'caption' => 'Brand'],
        ]],
    ];

    protected static array $buyer = [
        ['route' => 'buyer.profil.index', 'caption' => 'Profil', 'icon' => 'ki-user', 'focus' => true],
        ['route' => 'buyer.pesana_saya.riwayat_pekerjaan.index', 'caption' => 'Pesanan Saya', 'icon' => 'ki-basket', 'focus' => true],
        ['route' => 'buyer.notifikasi.riwayat_pendidikan.index', 'caption' => 'Notifikasi', 'icon' => 'ki-notification', 'focus' => true],
        ['route' => 'buyer.vouncher_saya.portofolio.index', 'caption' => 'Voucher Saya', 'icon' => 'ki-discount', 'focus' => true],
        ['route' => 'buyer.ubah_password.dokumen.index', 'caption' => 'Ubah Password', 'icon' => 'ki-lock', 'focus' => true],
    ];

    protected static array $seller = [];
    protected static array $shipper = [];
    protected static array $shipper_sub = [];
    protected static array $courier = [];

    public function list_menu($role): array
    {
        return match ($role) {
            "Administrator" => self::$admin,
            "Buyer" => self::$buyer,
            "Seller" => self::$seller,
            "Shipper" => self::$shipper,
            "Shipper Sub" => self::$shipper_sub,
            "Courier" => self::$courier,
            default => [],
        };
    }

    public static function current_menu($menus, $current_route, $role_active, $current_route_params = [])
    {
        unset($current_route_params['warehouse_selected'], $current_route_params['date'], $current_route_params['page'], $current_route_params['tab_active']);

        $segments = explode('.', $current_route);
        $breadcrumbs = [];

        foreach ($segments as $index => $segment) {
            if ($segment !== 'index') {
                $route_partial = implode('.', array_slice($segments, 0, $index + 1));
                $caption = ucwords(str_replace('_', ' ', $segment)); // Kapital di setiap kata
                $breadcrumbs[] = ['route' => $route_partial, 'caption' => $caption];
            }
        }

        $current_menu = [];
        $current_sub_menu = [];
        $current_side_menu = [];

        foreach ($menus as $menu) {
            if ($menu['route'] === $current_route && ($menu['params'] ?? []) === $current_route_params) {
                $current_menu = $menu;
                if (empty($breadcrumbs) || last($breadcrumbs)['caption'] !== $menu['caption']) {
                    $breadcrumbs[] = $menu;
                }
            }

            foreach ($menu['sub_menus'] ?? [] as $sub_menu) {
                if ($sub_menu['route'] === $current_route && ($sub_menu['params'] ?? []) === $current_route_params) {
                    $current_menu = $menu;
                    $current_sub_menu = $sub_menu;

                    if ($sub_menu['route'] !== $menu['route']) {
                        if (empty($breadcrumbs) || last($breadcrumbs)['caption'] !== $sub_menu['caption']) {
                            $breadcrumbs[] = $sub_menu;
                        }
                    }
                }

                foreach ($sub_menu['side_menus'] ?? [] as $side_menu) {
                    if ($side_menu['route'] === $current_route && ($side_menu['params'] ?? []) === $current_route_params) {
                        $current_menu = $menu;
                        $current_sub_menu = $sub_menu;
                        $current_side_menu = $side_menu;

                        if (empty($breadcrumbs) || last($breadcrumbs)['caption'] !== $sub_menu['caption']) {
                            $breadcrumbs[] = $sub_menu;
                        }
                        if (empty($breadcrumbs) || last($breadcrumbs)['caption'] !== $side_menu['caption']) {
                            $breadcrumbs[] = $side_menu;
                        }
                    }
                }
            }

            foreach ($menu['side_menus'] ?? [] as $side_menu) {
                if ($side_menu['route'] === $current_route && ($side_menu['params'] ?? []) === $current_route_params) {
                    $current_menu = $menu;
                    $current_side_menu = $side_menu;

                    if (last($breadcrumbs)['route'] !== $menu['route']) {
                        if (empty($breadcrumbs) || last($breadcrumbs)['caption'] !== $menu['caption']) {
                            $breadcrumbs[] = $menu;
                        }
                    }

                    if ($side_menu['route'] !== $menu['route'] || ($side_menu['params'] ?? []) !== ($menu['params'] ?? [])) {
                        if (empty($breadcrumbs) || last($breadcrumbs)['caption'] !== $side_menu['caption']) {
                            $breadcrumbs[] = $side_menu;
                        }
                    }
                }
            }
        }

        if (empty($current_menu)) {
            $temp = explode('.', $current_route);
            if (last($temp) === 'show' || last($temp) === 'create') {
                $temp[count($temp) - 1] = 'index';
                $current_route = join('.', $temp);
                return self::current_menu($menus, $current_route, $role_active, $current_route_params);
            } elseif (count($temp) > 2) {
                array_splice($temp, count($temp) - 2, 1);
                $current_route = join('.', $temp);
                return self::current_menu($menus, $current_route, $role_active, $current_route_params);
            }
        }

        $current = $current_side_menu ?: ($current_sub_menu ?: $current_menu);
        $actions = $current['actions'] ?? [];

        return [
            'current_menu' => $current_menu,
            'current_sub_menu' => $current_sub_menu,
            'current_side_menu' => $current_side_menu,
            'breadcrumbs' => $breadcrumbs,
            'actions' => $actions,
        ];
    }
}
