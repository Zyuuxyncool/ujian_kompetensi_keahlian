@extends('buyer.layouts.index')

@section('title')
    Verifikasi Data Diri -
@endsection

@section('content')
    <div class="container py-10">
        {{-- HEADER DAN TOMBOL SIMPAN (SAMA) --}}
        <div class="d-flex justify-content-between align-items-center mb-6">
            <a href="#" class="text-dark fs-3 fw-bold">
                <i class="fas fa-arrow-left me-2"></i> {{-- Ikon kembali --}}
            </a>
            <h1 class="fs-2 fw-bold m-0">Verifikasi Data Diri</h1>
            <button class="btn btn-sm btn-link text-danger fw-bold">Simpan</button>
        </div>

        {{-- NAVIGATION STEPPER (SAMA) --}}
        <div class="d-flex justify-content-between align-items-center mb-10">
            <div class="text-center">
                <span class="d-inline-block bg-success rounded-circle" style="width:10px;height:10px;"></span>
                <div class="text-success fw-bold mt-2">Verifikasi Data Diri</div>
            </div>
            <div class="text-center">
                <span class="d-inline-block bg-secondary rounded-circle" style="width:10px;height:10px;"></span>
                <div class="text-gray-400 fw-bold mt-2">Informasi Toko</div>
            </div>
            <div class="text-center">
                <span class="d-inline-block bg-secondary rounded-circle" style="width:10px;height:10px;"></span>
                <div class="text-gray-400 fw-bold mt-2">Upload Produk</div>
            </div>
        </div>


        {{-- CARD FORM CONTENT --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-8">
                <form action="{{ route('buyer.seller.verify.store') }}" method="POST">
                    @csrf

                    <h3 class="fs-5 fw-bold mb-4">Jenis Usaha <span class="text-danger">*</span></h3>
                    <div class="d-flex flex-column gap-2 mb-8">
                        <x-radio name="jenis_usaha" value="1" caption="Perorangan" :checked="$profil->jenis_usaha ?? '' == 1" />

                        <x-radio name="jenis_usaha" value="2" caption="Perusahaan (PT/CV)" :checked="$profil->jenis_usaha ?? '' == 2" />
                    </div>

                    <hr class="my-8">

                    <div class="mb-8">
                        <label class="form-label fs-5 fw-bold">Nama <span class="text-danger">*</span></label>
                        <x-input name="nama" caption="Nama" :value="$profil->nama ?? ''" />
                    </div>

                    <div class="mb-8">
                        <label class="form-label fs-5 fw-bold">NIK <span class="text-danger">*</span></label>
                        <x-input name="nik" caption="NIK" :value="$profil->nik ?? ''" />
                    </div>

                    <div class="d-flex justify-content-between pt-6 border-top">
                        <button type="button" class="btn btn-secondary px-8">Kembali</button>
                        <button type="submit" class="btn btn-success px-8">Lanjut</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Logika tambahan jika ada
    </script>
@endpush
