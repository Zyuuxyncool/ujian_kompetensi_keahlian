<div id="kt_header" class="header border-bottom-0 shadow-sm">
    <div class="container-fluid d-flex align-items-center justify-content-between py-3 px-lg-8">

        {{-- === Logo / Brand === --}}
        <div class="d-flex align-items-center gap-3">
            @if (count($current_side_menu ?? []) > 0)
                <button class="btn btn-icon btn-active-icon-primary d-lg-none" id="kt_aside_toggle">
                    <i class="ki-duotone ki-abstract-14 fs-2">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                </button>
            @endif
            <a href="{{ url('/buyer/landing') }}" class="text-decoration-none">
                <h1 class="header-title mb-0">Nusantara <span class="text-siap">Store</span></h1>
            </a>
        </div>

        {{-- === Search Bar (tengah mirip Shopee) === --}}
        <div class="d-none d-lg-flex flex-grow-1 justify-content-center ms-lg-10">
            <form action="" method="GET" class="w-100" style="max-width: 420px;">
                <div
                    class="input-group nusantara-search rounded-pill overflow-hidden border border-success shadow-elevated">
                    <input type="text" name="q" class="form-control border-0 ps-4 py-2"
                        placeholder="Cari produk, toko, atau kategori..." aria-label="Search" required>
                    <button type="submit"
                        class="btn btn-nusantara-icon d-flex align-items-center justify-content-center px-4">
                        <i class="fa fa-search fs-5 text-white"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- === Menu kanan (notif, user, login) === --}}
        <div class="d-flex align-items-center gap-4">
            @guest
                <a href="{{ route('login') }}"
                    class="btn btn-outline btn-active-success border-success btn-sm fs-6 px-6 py-2"
                    style="border-width: 2px">
                    Login / Register
                </a>
            @endguest

            @auth
                @include('buyer.layouts._cart')
                @include('buyer.layouts._notification')
                @include('buyer.layouts._user')
            @endauth

            {{-- Mobile toggle --}}
            <button class="btn btn-icon btn-active-light-primary d-lg-none" id="kt_header_menu_mobile_toggle">
                <i class="ki-duotone ki-text-align-left fs-2 fw-bold">
                    <span class="path1"></span><span class="path2"></span>
                    <span class="path3"></span><span class="path4"></span>
                </i>
            </button>
        </div>

    </div>
</div>
