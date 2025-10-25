@extends('buyer.layouts.index')

@section('title')
    Hasil Pencarian: {{ $query }} -
@endsection

@section('content')
    <div class="container py-4">

        {{-- JUDUL --}}
        <div class="text-center text-md-start mb-4">
            <h1 class="fs-5 fw-semibold text-dark mb-1">
                Hasil pencarian untuk <span class="text-primary">“{{ $query }}”</span>
            </h1>
            <p class="text-muted small mb-0">
                Menampilkan <strong>{{ $result_count }}</strong> produk yang cocok
            </p>
        </div>

        {{-- BLOK TOKO BERKAITAN --}}
        @if (!empty($related_store))
            <div class="related-store-card mb-5 p-3 p-md-4 bg-white rounded-4 shadow-sm">
                <div class="d-flex align-items-center flex-wrap gap-3">

                    {{-- Avatar --}}
                    <div class="position-relative">
                        <img src="https://placehold.co/72x72/f8f9fa/343a40?text=T"
                            alt="{{ $related_store->nama_toko }}"
                            class="rounded-circle border border-light shadow-sm" width="72" height="72">
                        <span
                            class="position-absolute bottom-0 start-0 small px-2 py-0 text-dark bg-warning fw-bold rounded-start rounded-bottom-0"
                            style="font-size: 0.65rem;">Star+</span>
                    </div>

                    {{-- Informasi Toko --}}
                    <div class="flex-grow-1">
                        <h6 class="fw-bold mb-1">{{ $related_store->nama_toko }}</h6>
                        <p class="text-muted small mb-2">@{{ $related_store->username }}</p>

                        <div class="d-flex flex-wrap align-items-center gap-3 small text-muted">
                            <div>
                                <span class="fw-semibold text-success">
                                    {{ number_format($related_store->product_count / 1000, 1) }}RB
                                </span> Produk
                            </div>
                            <div>|</div>
                            <div>
                                <span class="fw-semibold text-success">
                                    {{ number_format($related_store->rating_review, 1) }}
                                </span> Penilaian
                            </div>
                            <div>|</div>
                            <div>
                                <span class="fw-semibold text-success">
                                    {{ number_format($related_store->followers / 1000, 1) }}RB
                                </span> Pengikut
                            </div>
                        </div>
                    </div>

                    {{-- Tombol ke Toko --}}
                    <div class="ms-auto">
                        <a href="#" class="btn btn-outline-success btn-sm px-3 fw-semibold">
                            Kunjungi Toko
                        </a>
                    </div>
                </div>
            </div>
        @endif

        {{-- LIST PRODUK --}}
        @if ($result_count > 0)
            <div class="row g-3 g-md-4">
                @foreach ($results as $product)
                    <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                        <a href="#" class="text-decoration-none text-dark d-flex flex-column h-100">
                            <div
                                class="product-card h-100 d-flex flex-column bg-white rounded-4 shadow-sm overflow-hidden position-relative border-0">

                                {{-- Gambar --}}
                                <div class="position-relative w-100 ratio ratio-1x1 overflow-hidden">
                                    @if ($product->first_image)
                                        <img src="{{ Storage::url($product->first_image->photo) }}"
                                            alt="{{ $product->name }}"
                                            class="w-100 h-100 object-fit-cover transition-smooth">
                                    @else
                                        <img src="https://placehold.co/400x400/F3F4F6/9CA3AF?text=NO+IMAGE"
                                            alt="Tidak Ada Gambar"
                                            class="w-100 h-100 object-fit-cover transition-smooth">
                                    @endif
                                </div>

                                {{-- Info Produk --}}
                                <div class="flex-grow-1 d-flex flex-column justify-content-between p-2 p-md-3">
                                    <p class="fw-semibold mb-2 text-truncate-2" style="font-size: 0.9rem;">
                                        {{ $product->name }}
                                    </p>

                                    <p class="fw-bold text-success mb-2" style="font-size: 1rem;">
                                        Rp{{ number_format($product->price, 0, ',', '.') }}
                                    </p>

                                    {{-- Rating dan Terjual --}}
                                    @php
                                        $rating = $product->rating ?? 0;
                                        $sold_count = $product->sold_count ?? 0;
                                    @endphp
                                    <div class="d-flex align-items-center small text-muted mb-1">
                                        <span class="text-warning me-1">
                                            @for ($i = 0; $i < 5; $i++)
                                                @if ($rating > $i)
                                                    <i class="fas fa-star fa-xs"></i>
                                                @else
                                                    <i class="far fa-star fa-xs"></i>
                                                @endif
                                            @endfor
                                        </span>
                                        <span>{{ number_format($rating, 1) }}</span>
                                        @if ($sold_count > 0)
                                            <span class="ms-2">Terjual {{ $sold_count }}</span>
                                        @endif
                                    </div>

                                    {{-- Lokasi --}}
                                    @if ($product->profil && $product->profil->location)
                                        <div class="text-muted small d-flex align-items-center">
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
            <div class="text-center py-5 bg-light rounded-4 shadow-sm">
                <i class="fas fa-search fa-2x text-secondary mb-3"></i>
                <h6 class="fw-semibold">Tidak ada hasil ditemukan</h6>
                <p class="text-muted small">Coba kata kunci lain atau periksa ejaan Anda.</p>
            </div>
        @endif
    </div>

    @push('styles')
        <style>
            .product-card {
                transition: all 0.25s ease-in-out;
            }

            .product-card:hover {
                transform: translateY(-4px);
                box-shadow: 0 8px 16px rgba(0, 0, 0, 0.08);
            }

            /* Gambar full rapat */
            .object-fit-cover {
                object-fit: cover;
            }

            /* Efek halus */
            .transition-smooth {
                transition: transform 0.3s ease, opacity 0.3s ease;
            }

            .product-card:hover img {
                transform: scale(1.05);
            }

            /* Dua baris teks maksimal */
            .text-truncate-2 {
                display: -webkit-box;
                -webkit-line-clamp: 2;
                -webkit-box-orient: vertical;
                overflow: hidden;
            }

            /* Toko terkait */
            .related-store-card {
                border: 1px solid #e9ecef;
                transition: all 0.2s ease;
            }

            .related-store-card:hover {
                box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
                transform: translateY(-2px);
            }

            @media (max-width: 767.98px) {
                .product-card {
                    border-radius: 8px;
                }

                .text-truncate-2 {
                    font-size: 0.8rem;
                }

                .related-store-card {
                    padding: 1rem;
                }
            }
        </style>
    @endpush
@endsection
