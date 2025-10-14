@extends('buyer.layouts.index')

@section('title')
    Landing Page -
@endsection

@section('content')
<div class="content flex-column-fluid" id="kt_content">
    {{-- Toolbar & Breadcrumb --}}
    <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
        <div class="page-title d-flex flex-column py-1 w-100 align-items-center">
            <h1 class="d-flex align-items-center my-1">
                <span class="text-dark fw-bold fs-1">Landing Page</span>
            </h1>
            <div class="breadcrumb-wrapper mt-1">
                @include('buyer.layouts._breadcrumbs')
            </div>
        </div>
    </div>

    {{-- KATEGORI --}}
    <div class="container py-10">
        <div class="bg-white p-3 rounded-4 shadow-sm position-relative overflow-hidden" style="max-width: 60%; margin: 0 auto;">

            {{-- Judul Kategori --}}
            <h5 class="fw-bold text-gray-800 mb-3 px-2">KATEGORI</h5>

            {{-- Tombol Navigasi --}}
            <button class="nav-arrow left" id="scrollLeft" style="display: none;">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </button>
            <button class="nav-arrow right" id="scrollRight">
                <ion-icon name="chevron-forward-outline"></ion-icon>
            </button>

            {{-- Wrapper Kategori --}}
            <div class="category-scroll" id="categoryContainer">
                @php
                    // Data Kategori (Total 26 kategori)
                    $categories = [
                        ['image' => 'elektronik.png', 'name' => 'Elektronik'],
                        ['image' => 'komputer.png', 'name' => 'Komputer & Aksesoris'],
                        ['image' => 'handphone.png', 'name' => 'Handphone & Aksesoris'],
                        ['image' => 'pakaian_pria.png', 'name' => 'Pakaian Pria'],
                        ['image' => 'sepatu_pria.png', 'name' => 'Sepatu Pria'],
                        ['image' => 'tas_pria.png', 'name' => 'Tas Pria'],
                        ['image' => 'aksesoris_fashion.png', 'name' => 'Aksesoris Fashion'],
                        ['image' => 'jam_tangan.png', 'name' => 'Jam Tangan'],
                        ['image' => 'kesehatan.png', 'name' => 'Kesehatan'],
                        ['image' => 'hobi.png', 'name' => 'Hobi & Koleksi'], 

                        ['image' => 'makanan.png', 'name' => 'Makanan & Minuman'],
                        ['image' => 'kecantikan.png', 'name' => 'Perawatan & Kecantikan'],
                        ['image' => 'perlengkapan.png', 'name' => 'Perlengkapan Rumah'],
                        ['image' => 'pakaian_wanita.png', 'name' => 'Pakaian Wanita'],
                        ['image' => 'fashion_muslim.png', 'name' => 'Fashion Muslim'],
                        ['image' => 'bayi.png', 'name' => 'Fashion Bayi & Anak'],
                        ['image' => 'ibu.png', 'name' => 'Ibu & Bayi'],
                        ['image' => 'sepatu_wanita.png', 'name' => 'Sepatu Wanita'],
                        ['image' => 'tas_wanita.png', 'name' => 'Tas Wanita'],
                        ['image' => 'otomotif.png', 'name' => 'Otomotif'],

                        ['image' => 'olahraga.png', 'name' => 'Olahraga & Outdoor'],
                        ['image' => 'souvenir.png', 'name' => 'Souvenir & Dekorasi'],
                        ['image' => 'voucher.png', 'name' => 'Voucher'],
                        ['image' => 'buku.png', 'name' => 'Buku & Alat Tulis'],
                        ['image' => 'fotografi.png', 'name' => 'Fotografi'],
                        ['image' => 'deals.png', 'name' => 'Deals Sekitarmu'],
                    ];
                @endphp

                <div class="category-grid">
                    @foreach ($categories as $category)
                        <div class="category-item text-center">
                            <div class="icon-wrapper">
                                <img src="{{ asset('images/kategori/' . $category['image']) }}" alt="{{ $category['name'] }}">
                            </div>
                            <div class="category-name">{{ $category['name'] }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CSS --}}
<style>
    /* Scroll Container */
    .category-scroll {
        scroll-behavior: smooth;
        overflow-x: auto;
        scrollbar-width: none;
    }
    .category-scroll::-webkit-scrollbar {
        display: none;
    }

    /* KUNCI PERBAIKAN: Mengurangi lebar kolom untuk memperpendek div */
    .category-grid {
        display: grid; 
        /* PERBAIKAN: Mengurangi lebar kolom menjadi 90px */
        grid-template-columns: repeat(13, 90px); 
        grid-auto-rows: 120px;
        gap: 0;
        /* Lebar total div sekarang adalah 13 * 90px = 1170px */
        width: max-content; 
        border-top: 1px solid #eee;
        border-left: 1px solid #eee;
    }

    /* Kategori Item */
    .category-item {
        /* Padding disesuaikan agar item 90px tidak terlalu kosong */
        padding: 8px 3px; 
        border-right: 1px solid #eee;
        border-bottom: 1px solid #eee;
        cursor: pointer;
        transition: all 0.3s ease;
        background: #fff;
        box-sizing: border-box; 
        /* Penting: Teks harus tetap center dalam lebar 90px */
        text-align: center;
    }

    .category-item:hover {
        background: #f7f7f7;
        transform: translateY(-3px);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.05);
    }

    /* Icon */
    .icon-wrapper {
        width: 60px; 
        height: 60px;
        border-radius: 50%;
        border: none;
        background: none; 
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 5px;
        transition: transform 0.3s ease;
        overflow: hidden;
    }

    .icon-wrapper img {
        max-width: 90%;
        max-height: 90%;
        object-fit: contain;
        transition: transform 0.3s ease;
    }

    .category-item:hover .icon-wrapper img {
        transform: scale(1.05);
    }

    .category-name {
        font-size: 0.7rem; /* Dikecilkan lagi agar muat di lebar 90px */
        font-weight: 500;
        color: #333;
        height: 30px;
        line-height: 1.2;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        white-space: normal;
    }

    /* Panah Navigasi Bulat dan Tanpa Warna Oranye */
    .nav-arrow {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 50%; 
        width: 35px;
        height: 35px;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        z-index: 10;
        transition: all 0.3s;
        color: #555;
    }

    .nav-arrow:hover {
        background: #f8f9fa; /* Abu-abu muda */
        color: #333;
        border-color: #ccc;
        transform: translateY(-50%) scale(1.05);
    }

    .nav-arrow.left { left: 5px; }
    .nav-arrow.right { right: 5px; }
</style>

{{-- Ionicons --}}
{{-- <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script> --}}
{{-- <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script> --}}

{{-- JS --}}
<script>
    const container = document.getElementById('categoryContainer');
    // Scroll amount dikurangi karena item lebih kecil
    const scrollAmount = 350;

    const leftArrow = document.getElementById('scrollLeft');
    const rightArrow = document.getElementById('scrollRight');

    rightArrow.onclick = () => container.scrollBy({ left: scrollAmount, behavior: 'smooth' });
    leftArrow.onclick = () => container.scrollBy({ left: -scrollAmount, behavior: 'smooth' });

    function checkArrows() {
        leftArrow.style.display = container.scrollLeft > 5 ? 'flex' : 'none';
        rightArrow.style.display =
            container.scrollLeft + container.clientWidth >= container.scrollWidth - 5
                ? 'none'
                : 'flex';
    }

    container.addEventListener('scroll', checkArrows);
    window.addEventListener('resize', checkArrows);
    checkArrows(); 
</script>
@endsection