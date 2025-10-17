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
        <div class="container-fluid py-10">
            <div class="bg-white p-3 rounded-4 shadow-sm position-relative overflow-hidden category-card-wrapper">
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
                    <div class="category-grid">
                        @foreach ($category as $item)
                            <a href="{{ route('buyer.landing.category.index', $item->uuid) }}" class="text-decoration-none">
                                <div class="category-item text-center">
                                    <div class="icon-wrapper"> <img
                                            src="{{ $item->photo ? Storage::url($item->photo) : asset('images/default.png') }}"
                                            alt="{{ $item->name }}"> </div>
                                    <div class="category-name">{{ $item->name }}</div>
                                </div>
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const container = document.getElementById('categoryContainer');
        const scrollAmount = 350;

        const leftArrow = document.getElementById('scrollLeft');
        const rightArrow = document.getElementById('scrollRight');

        // Aktifkan tombol panah untuk semua ukuran layar
        rightArrow.onclick = () => container.scrollBy({
            left: scrollAmount,
            behavior: 'smooth'
        });

        leftArrow.onclick = () => container.scrollBy({
            left: -scrollAmount,
            behavior: 'smooth'
        });

        function checkArrows() {
            leftArrow.style.display = container.scrollLeft > 5 ? 'flex' : 'none';
            rightArrow.style.display =
                container.scrollLeft + container.clientWidth >= container.scrollWidth - 5 ?
                'none' :
                'flex';
        }

        container.addEventListener('scroll', checkArrows);
        window.addEventListener('resize', checkArrows);
        checkArrows();
    </script>
@endpush
