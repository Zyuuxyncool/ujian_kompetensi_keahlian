<!DOCTYPE html>
<html lang="en">

<head>
    <base href="{{ url('/') }}" />
    <title>@yield('title') {{ env('APP_NAME') }}</title>
    <meta charset="utf-8" />
    <meta name="token" content="{{ csrf_token() }}" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/favicon.png') }}" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @stack('css_plugins')
    <link href="{{ asset('assets_admin/plugins/custom/bootstrap-datepicker/bootstrap-datepicker.min.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('assets_admin/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />


    <link href="{{ asset('assets_admin/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets_admin/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <style>
        /* === Sticky Header === */
        #kt_header {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1050;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(8px);
            border-bottom: 1px solid rgba(15, 160, 97, 0.2);
            transition: all 0.3s ease;
        }

        /* Rapikan spacing */
        .header .container-fluid {
            padding-left: 2rem;
            padding-right: 2rem;
        }

        /* Search bar hover */
        .nusantara-search:hover {
            border-color: var(--nusantara-gold) !important;
            box-shadow: 0 0 8px rgba(15, 160, 97, 0.25);
        }

        /* Header scroll efek */
        .scrolled #kt_header {
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            background: #fff;
        }

        /* Text rapi di tengah vertikal */
        .header-title {
            display: flex;
            align-items: center;
            font-size: 1.5rem;
        }

        body {
            margin: 0;
            padding-top: 76px;
        }

        /* === Warna utama Nusantara === */
        :root {
            --nusantara-green: #0FA061;
            --nusantara-gold: #C7954A;
        }

        /* === Search bar === */
        .nusantara-search {
            background: #fff;
            transition: all 0.3s ease;
        }

        .nusantara-search input {
            font-size: 1rem;
        }

        .nusantara-search:hover {
            border-color: var(--nusantara-gold) !important;
            box-shadow: 0 0 10px rgba(15, 160, 97, 0.2);
        }

        /* === Tombol ikon kaca pembesar === */
        .btn-nusantara-icon {
            background: linear-gradient(90deg, var(--nusantara-green), var(--nusantara-gold));
            border: none;
            transition: all 0.3s ease;
            width: 56px;
        }

        .btn-nusantara-icon:hover {
            opacity: 0.9;
            transform: scale(1.05);
        }

        /* === Tombol login === */
        .hover-nusantara:hover {
            background: linear-gradient(90deg, var(--nusantara-green), var(--nusantara-gold));
            color: #fff !important;
            border: none !important;
        }

        /* === Logo size === */
        .h-45px {
            height: 45px !important;
        }

        .h-lg-50px {
            height: 50px !important;
        }

        body {
            background: linear-gradient(135deg, #F5F5F5 0%, #E8F5E9 40%, #F1F8E9 100%);
            background-attachment: fixed;
            background-size: cover;
            min-height: 100vh;
        }

        [data-theme="dark"] body {
            background: linear-gradient(135deg, #1B1B1B 0%, #2C2C2C 40%, #1E1E1E 100%);
        }

        .header-title {
            font-size: 28px;
            font-weight: 800;
            background: linear-gradient(90deg, #9E6B3E, #00796B);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 0.5px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s ease;
        }

        .header-title:hover {
            transform: scale(1.03);
            opacity: 0.9;
        }

        @media (max-width: 576px) {
            .header-title {
                font-size: 20px;
            }
        }

        .border-solid {
            border-style: solid !important;
        }

        .shadow-elevated {
            box-shadow: 0px 2px 2px rgba(28, 36, 51, 0.1);
        }

        .text-siap {
            color: #0FA061 !important;
        }

        .bg-siap {
            background-color: #0FA061 !important;
        }

        .hover-border-dark:hover {
            border-color: #404443 !important;
        }

        .hover-shadow-lg {
            transition: box-shadow 0.3s ease-in-out;
        }

        .hover-shadow-lg:hover {
            box-shadow: 0 1rem 2rem 1rem rgba(0, 0, 0, .1) !important;
        }

        .event-image {
            overflow: hidden;
        }

        .event-image img {
            transition: transform 0.3s ease;
        }

        .event-image:hover img {
            transform: scale(1.2);
        }

        .carousel-custom .carousel-indicators.carousel-indicators-bullet li {
            width: 10px;
            height: 10px;
        }

        .carousel-custom .carousel-indicators.carousel-indicators-bullet li:after {
            width: 10px;
            height: 10px;
        }

        .carousel-custom .carousel-indicators.carousel-indicators-bullet li.active {
            height: 10px;
            width: 26px;
        }

        .carousel-custom .carousel-indicators.carousel-indicators-bullet li.active:after {
            height: 10px;
            width: 26px;
        }

        @keyframes wiggle {
            0% {
                transform: translateX(0);
            }

            25% {
                transform: translateX(-4px);
            }

            50% {
                transform: translateX(4px);
            }

            75% {
                transform: translateX(-4px);
            }

            100% {
                transform: translateX(0);
            }
        }

        .wiggle-icon {
            animation: wiggle 0.6s infinite ease-in-out;
        }



        @media (min-width: 1400px) {

            .container,
            .container-lg,
            .container-md,
            .container-sm,
            .container-xl,
            .container-xxl {
                max-width: 82%;
            }
        }

        @media (min-width: 992px) {
            .header {
                height: 74px;
            }

            .menu-root-here-bg-desktop>.menu-item.here>.menu-link {
                background: unset;
            }

            .menu-state-primary .menu-item.here>.menu-link .menu-title {
                color: #0daa66;
                border-bottom: 2px solid #0daa66;
            }

            .header .header-menu .menu>.menu-item>.menu-link>.menu-title {
                font-size: 1.05rem;
                position: relative;
                display: inline-block;
            }

            .header .header-menu .menu>.menu-item>.menu-link>.menu-title::after {
                content: "";
                position: absolute;
                bottom: -2px;
                left: 0;
                width: 0;
                height: 2px;
                background-color: #0daa66;
                transition: width 0.3s ease;
            }

            .header .header-menu .menu>.menu-item>.menu-link:hover>.menu-title {
                color: #0daa66 !important;
            }

            .header .header-menu .menu>.menu-item>.menu-link:hover>.menu-title::after {
                width: 100%;
            }

        }

        /* === Footer Nusantara === */
        .footer-nusantara {
            background-color: #111;
            /* hitam elegan */
            color: #fff;
            font-family: 'Poppins', sans-serif;
        }

        .footer-brand {
            font-size: 1.8rem;
            font-weight: 800;
            background: linear-gradient(90deg, #0FA061, #C7954A);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            letter-spacing: 0.5px;
        }

        .footer-heading {
            color: #fff;
            font-weight: 600;
            margin-bottom: 1rem;
            font-size: 1rem;
            letter-spacing: 0.5px;
        }

        .footer-links {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: #bbb;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .footer-links a:hover {
            color: #0FA061;
            padding-left: 4px;
        }

        .footer-social {
            width: 40px;
            height: 40px;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            color: #fff;
            font-size: 1rem;
            transition: all 0.3s ease;
        }

        .footer-bottom {
            border-color: rgba(255, 255, 255, 0.1) !important;
        }
    </style>
    @stack('styles')
</head>

<body id="kt_body" class="@yield('body-class')">

    <div class="d-flex flex-column flex-root">
        <div class="page d-flex flex-column flex-column-fluid">
            @include('buyer.layouts._header')

            <div id="kt_content_container" class="d-flex flex-column-fluid align-items-stretch">
                <div class="wrapper d-flex flex-column flex-row-fluid" id="kt_wrapper">
                    @yield('content')

                    <footer class="footer-nusantara mt-20">
                        <div class="container py-14">
                            <div class="row g-10 justify-content-between align-items-start">

                                <!-- Brand -->
                                <div class="col-lg-4 col-md-6 mb-10 mb-lg-0">
                                    <h1 class="footer-brand mb-4">Nusantara Store</h1>
                                    <p class="text-gray-400 fs-6 pe-lg-10">
                                        Marketplace lokal dengan semangat Nusantara — menghubungkan penjual dan pembeli
                                        dari seluruh pelosok negeri.
                                    </p>
                                </div>

                                <!-- Navigasi -->
                                <div class="col-lg-2 col-md-4 mb-10 mb-lg-0">
                                    <h6 class="footer-heading">Jelajahi</h6>
                                    <ul class="footer-links">
                                        <li><a href="#">Tentang Kami</a></li>
                                        <li><a href="#">Karier</a></li>
                                        <li><a href="#">Kontak</a></li>
                                        <li><a href="#">Kebijakan Privasi</a></li>
                                    </ul>
                                </div>

                                <!-- Bantuan -->
                                <div class="col-lg-2 col-md-4 mb-10 mb-lg-0">
                                    <h6 class="footer-heading">Bantuan</h6>
                                    <ul class="footer-links">
                                        <li><a href="#">Pusat Bantuan</a></li>
                                        <li><a href="#">Pengembalian Barang</a></li>
                                        <li><a href="#">Syarat & Ketentuan</a></li>
                                        <li><a href="#">Kebijakan Penjual</a></li>
                                    </ul>
                                </div>

                                <!-- Sosial Media -->
                                <div class="col-lg-3 col-md-6">
                                    <h6 class="footer-heading">Ikuti Kami</h6>
                                    <div class="d-flex gap-3 mt-3">
                                        <a href="#" class="footer-social"><i class="fab fa-facebook-f"></i></a>
                                        <a href="#" class="footer-social"><i class="fab fa-instagram"></i></a>
                                        <a href="#" class="footer-social"><i class="fab fa-linkedin-in"></i></a>
                                    </div>
                                </div>
                            </div>

                            <div class="footer-bottom text-center mt-12 pt-6 border-top border-secondary">
                                <p class="text-gray-500 fs-7 mb-0">
                                    © {{ date('Y') }} <span class="text-siap fw-semibold">Nusantara Store</span> —
                                    Dibangun dengan semangat Nusantara 🇮🇩
                                </p>
                            </div>
                        </div>
                    </footer>


                </div>
            </div>
        </div>
    </div>

    @stack('modals')

    <div id="error_log_display"></div>

    <script>
        const hostUrl = "{{ asset('assets') }}/";
    </script>
    <script>
        const baseUrl = "{{ url('/') }}";
    </script>
    <script src="{{ asset('assets_admin/plugins/global/plugins.bundle.js') }}"></script>
    @stack('js_plugins')
    <!-- Ionicons CDN -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <script src="{{ asset('assets_admin/js/scripts.bundle.js') }}"></script>
    <script src="{{ asset('assets_admin/plugins/custom/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('assets_admin/js/auto-numeric.js') }}"></script>
    <script src="{{ asset('assets_admin/js/io.js') }}"></script>
    <script>
        @if (session()->has('success'))
            swal.fire('{{ session('success') }}');
        @endif
        @if (session()->has('error'))
            Swal.fire({
                icon: "error",
                title: "{{ session('error') }}",
            });
        @endif
        document.addEventListener('scroll', function() {
            if (window.scrollY > 20) {
                document.body.classList.add('scrolled');
            } else {
                document.body.classList.remove('scrolled');
            }
        });
    </script>
    @stack('scripts')
</body>

</html>
