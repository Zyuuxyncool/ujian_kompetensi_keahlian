@extends('buyer.layouts.index')

@section('title')
    Hasil Pencarian: {{ $query }} -
@endsection

@section('content')
    <div class="container py-4">
        <h1 class="fs-5 fw-semibold mb-2 text-dark text-center text-md-start">
            Hasil Pencarian untuk: <span class="text-primary">"{{ $query }}"</span>
        </h1>
        <p class="text-muted small mb-4 text-center text-md-start">
            Menampilkan <strong>{{ $result_count }}</strong> produk yang cocok
        </p>


        {{-- BLOK BARU: TOKO BERKAITAN --}}
        @php
            // Perbaikan: Hapus semua logika dummy/override.
            // Asumsi data $related_store berasal dari controller.
            // Gunakan nilai default sederhana jika properti toko tidak tersedia.

            // Cek apakah $related_store ada dan bukan null
            $show_related_store = !empty($related_store);

            // Asumsi data properti penting untuk rendering
            if ($show_related_store) {
                $related_store->nama_toko = $related_store->nama_toko ?? 'TOKO TERKAIT';
                $related_store->username = $related_store->username ?? 'user_toko';

                // Asumsi data statistik, Anda mungkin perlu mengambil ini dari service lain
                // Namun untuk keperluan tampilan, kita asumsikan properti ini ada (atau beri default 0)
                $related_store->product_count = $related_store->product_count ?? 0;
                $related_store->rating_review = $related_store->rating_review ?? 0.0;
                $related_store->followers = $related_store->followers ?? 0;
                $related_store->chat_response_rate = $related_store->chat_response_rate ?? 0;
                $related_store->chat_response_time = $related_store->chat_response_time ?? '-';
            }
        @endphp

        @if ($show_related_store)
            <div class="mb-4">
                {{-- Header TOKO BERKAITAN --}}
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h5 class="small fw-semibold text-uppercase text-muted mb-0">
                        TOKO BERKAITAN DENGAN "<span class="text-success">{{ $related_store->nama_toko }}</span>"
                    </h5>
                    {{-- Tombol Toko Lainnya di Desktop (d-none di mobile, d-block di md+) --}}
                    <a href="#" class="text-decoration-none text-success small fw-semibold d-none d-md-block">
                        Toko Lainnya
                        <i class="fas fa-angle-right ms-1"></i>
                    </a>
                </div>

                {{-- Konten Utama Toko --}}
                <div class="bg-white p-3 border rounded-3 d-flex align-items-center justify-content-between">

                    {{-- Bagian Kiri: Info Toko (Avatar, Nama, Followers/Produk & Penilaian) --}}
                    <div class="d-flex align-items-center flex-grow-1">
                        {{-- Avatar Toko --}}
                        <div class="me-3 position-relative flex-shrink-0">
                            <img src="https://placehold.co/60x60/f8f9fa/343a40?text=T" alt="{{ $related_store->nama_toko }}"
                                class="rounded-circle border" style="width: 60px; height: 60px;">

                            {{-- Placeholder untuk label STAR+ --}}
                            <span
                                class="position-absolute bottom-0 start-0 small px-1 py-0 text-white bg-warning fw-bold rounded-start rounded-bottom-0"
                                style="z-index: 2; font-size: 0.6rem;">Star+</span>
                        </div>

                        {{-- Nama dan Info Toko --}}
                        <div class="me-3 me-md-0">
                            <h6 class="fw-bold mb-0">{{ $related_store->nama_toko }}</h6>
                            <p class="small text-muted mb-1">{{ $related_store->username }}</p>

                            {{-- INFO MOBILE: Produk | Penilaian (d-block di mobile, d-none di md+) --}}
                            <div class="small text-muted d-md-none">
                                <span
                                    class="me-2 fw-semibold text-success">{{ number_format($related_store->product_count / 1000, 1) }}RB</span>
                                <span class="me-2">Produk</span>
                                | <span
                                    class="ms-2 fw-semibold text-success">{{ number_format($related_store->rating_review, 1) }}</span>
                                <span class="ms-1">Penilaian</span>
                            </div>

                            {{-- INFO DESKTOP: Followers | Mengikuti (d-none di mobile, d-block di md+) --}}
                            <div class="small text-muted d-none d-md-block">
                                <span
                                    class="me-2 fw-semibold text-success">{{ number_format($related_store->followers / 1000, 1) }}RB</span>
                                <span class="me-2">Pengikut</span>
                                | <span class="ms-2">13 Mengikuti</span>
                            </div>
                        </div>
                    </div>

                    {{-- Statistik Toko (Produk | Penilaian | Chat) --}}
                    {{-- Bagian ini harus fleksibel di desktop dan menempel di kanan --}}
                    <div class="d-flex align-items-center flex-shrink-0">
                        {{-- Tombol Toko Lainnya di Mobile (d-none di md+) --}}
                        <div class="d-flex d-md-none align-self-center flex-shrink-0 me-2">
                            <a href="#" class="text-decoration-none text-success small fw-semibold">
                                Toko Lainnya
                                <i class="fas fa-angle-right ms-1"></i>
                            </a>
                        </div>

                        {{-- Statistik Tambahan (Desktop Only, d-none di mobile) --}}
                        <div class="d-none d-md-flex align-items-center justify-content-end flex-grow-1">
                            {{-- 1. Produk --}}
                            <div class="text-center mx-3" style="min-width: 60px;">
                                <h6 class="fw-bold text-success mb-0">
                                    {{ number_format($related_store->product_count / 1000, 1) }}RB</h6>
                                <p class="small text-muted mb-0">Produk</p>
                            </div>

                            {{-- 2. Penilaian --}}
                            <div class="text-center mx-3" style="min-width: 60px;">
                                <h6 class="fw-bold text-success mb-0">{{ $related_store->rating_review }}</h6>
                                <p class="small text-muted mb-0">Penilaian</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        {{-- AKHIR BLOK TOKO BERKAITAN --}}


        @if ($result_count > 0)
            <div class="row g-3 justify-content-start">
                @foreach ($results as $product)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <a href="#" class="text-decoration-none text-dark d-flex flex-column h-100 product-link">
                            <div class="d-flex flex-column bg-white h-100 border product-card">

                                {{-- Gambar Produk --}}
                                <div class="position-relative w-100" style="padding-top: 100%; overflow:hidden;">
                                    @if ($product->first_image)
                                        {{-- Menggunakan 'photo' sesuai struktur yang Anda berikan --}}
                                        <img src="{{ Storage::url($product->first_image->photo) }}"
                                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain"
                                            alt="{{ $product->name }}">
                                    @else
                                        <img src="https://placehold.co/400x400/F3F4F6/9CA3AF?text=NO+IMAGE"
                                            class="position-absolute top-0 start-0 w-100 h-100 object-fit-contain"
                                            alt="Tidak Ada Gambar">
                                    @endif
                                    {{-- Placeholder Label Promosi (Opsional) --}}
                                    {{-- <span class="position-absolute top-0 start-0 small px-2 py-1 text-white bg-success fw-bold rounded-end" style="z-index: 1;">PROMO</span> --}}
                                </div>

                                {{-- Bagian bawah --}}
                                <div class="p-2 d-flex flex-column justify-content-between flex-grow-1">

                                    {{-- 1. Nama Produk (Tetap Bold & Ukuran 0.875rem) --}}
                                    <div class="mb-1 flex-grow-1" style="min-height: 2.5rem;">
                                        <p class="mb-1 text-truncate-2 fw-bold"
                                            style="font-size: 0.875rem; line-height: 1.2;">{{ $product->name }}</p>
                                    </div>

                                    {{-- 2. Harga --}}
                                    <p class="fw-bold text-success mb-1" style="font-size: 1.1rem;">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </p>

                                    {{-- 3. Rating & Terjual --}}
                                    @php
                                        $rating = $product->rating ?? 0;
                                        $sold_count = $product->sold_count ?? 0;
                                    @endphp
                                    <div class="d-flex align-items-center mb-1" style="font-size: 0.75rem;">
                                        <span class="text-warning">
                                            @for ($i = 0; $i < 5; $i++)
                                                @if ($rating > $i)
                                                    <i class="fas fa-star fa-xs"></i>
                                                @else
                                                    <i class="far fa-star fa-xs"></i>
                                                @endif
                                            @endfor
                                        </span>
                                        <span class="ms-1 text-muted">({{ number_format($rating, 1) }})</span>
                                        @if ($sold_count > 0)
                                            <span class="ms-2 text-muted">Terjual {{ $sold_count }}</span>
                                        @endif
                                    </div>

                                    {{-- 4. Lokasi --}}
                                    @if ($product->profil && $product->profil->location)
                                        <div class="text-muted d-flex align-items-center mt-1" style="font-size: 0.7rem;">
                                            <i class="fas fa-map-marker-alt me-1"></i>
                                            <span class="text-truncate">{{ $product->profil->location }}</span>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 bg-light rounded">
                <i class="fas fa-search fa-2x text-secondary mb-3"></i>
                <h6>Tidak ada hasil ditemukan</h6>
                <p class="text-muted small">Coba kata kunci lain atau periksa ejaan Anda.</p>
            </div>
        @endif
    </div>

    {{-- Tambahan CSS --}}
    @push('styles')
        <style>
            .product-card {
                border-radius: 6px;
                transition: all 0.2s ease-in-out;
            }

            .product-card:hover {
                transform: translateY(-2px);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            }

            .object-fit-contain {
                object-fit: contain;
            }

            .text-truncate-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            /* Perbaikan tambahan untuk responsif pada blok toko (jika perlu) */
            @media (max-width: 767.98px) {
                .col-6 {
                    padding-left: 6px;
                    padding-right: 6px;
                }

                .product-card {
                    border-radius: 4px;
                }

                .text-truncate-2 {
                    -webkit-line-clamp: 2;
                    font-size: 0.8rem !important;
                }

                /* Statistik toko yang disembunyikan di mobile sudah dihandle dengan d-none */
            }
        </style>
    @endpush
@endsection
