@extends('buyer.layouts.index')

@section('title')
    Upload Produk -
@endsection

@section('content')
    <div class="container py-10">
        {{-- HEADER DAN TOMBOL SIMPAN --}}
        <div class="d-flex justify-content-between align-items-center mb-6">
            <a href="{{ route('buyer.seller.informasi_toko') }}" class="text-dark fs-3 fw-bold">
                <i class="fas fa-arrow-left me-2"></i> {{-- Ikon kembali --}}
            </a>
            <h1 class="fs-2 fw-bold m-0">Upload Produk</h1>
            <button type="submit" form="formUploadProduk" class="btn btn-sm btn-link text-danger fw-bold">
                Simpan
            </button>
        </div>

        {{-- NAVIGATION STEPPER --}}
        <div class="d-flex justify-content-between align-items-center mb-10">
            <div class="text-center">
                <span class="d-inline-block bg-success rounded-circle" style="width:10px;height:10px;"></span>
                <div class="text-success fw-bold mt-2">Verifikasi Data Diri</div>
            </div>
            <div class="text-center">
                <span class="d-inline-block bg-success rounded-circle" style="width:10px;height:10px;"></span>
                <div class="text-success fw-bold mt-2">Informasi Toko</div>
            </div>
            <div class="text-center">
                <span class="d-inline-block bg-success rounded-circle" style="width:10px;height:10px;"></span>
                <div class="text-success fw-bold mt-2">Upload Produk</div>
            </div>
        </div>

        {{-- FORM CARD --}}
        <div class="card shadow-sm border-0 rounded-4 p-6">
            <form id="formUploadProduk" action="{{ route('buyer.seller.upload_produk.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf

                {{-- Nama Produk --}}
                <div class="mb-4">
                    <label for="name" class="form-label fw-bold">Nama Produk</label>
                    <x-input name="name" caption="name" :value="$profil->name ?? ''" required />
                </div>

                {{-- Deskripsi --}}
                <div class="mb-4">
                    <label for="description" class="form-label fw-bold">Deskripsi Produk</label>
                    <textarea name="description" id="description" class="form-control form-control-lg" rows="4"
                        placeholder="Tulis deskripsi produk...">{{ old('description') }}</textarea>
                </div>

                {{-- Harga dan Stok --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="price" class="form-label fw-bold">Harga (Rp) </label>
                        <x-input name="price" caption="price" :value="$profil->price ?? ''" required class="autonumeric" />
                    </div>
                    <div class="col-md-6">
                        <label for="stock" class="form-label fw-bold">Stok</label>
                        <x-input name="stock" caption="stock" :value="$profil->stock ?? ''" required class="autonumeric" />
                    </div>
                </div>

                {{-- Sub Kategori dan Brand (opsional) --}}
                <div class="row mb-4">
                    <div class="col-md-6">
                        <label for="sub_category_id" class="form-label fw-bold">Sub Kategori</label>
                        <x-select name="sub_category_id" prefix="search_" :options="$list_sub_categories" class="form-select"
                            :value="$category_sub->name ?? ''" data-control="select2" />
                    </div>

                    <div class="col-md-6">
                        <label for="brand_id" class="form-label fw-bold">Brand</label>
                        <x-select name="brand_id" prefix="search_" :options="$list_brands" class="form-select" :value="$category_brand->name ?? ''"
                            data-control="select2" />
                    </div>
                </div>


                {{-- Upload Foto Produk --}}
                <div class="mb-4">
                    <label for="images" class="form-label fw-bold">Foto Produk</label>
                    <input type="file" name="images[]" id="images" class="form-control form-control-lg"
                        accept="image/*" multiple>
                    <small class="text-muted">Bisa upload lebih dari satu foto. Maksimal 5 foto disarankan.</small>
                </div>

                {{-- Preview Foto --}}
                <div id="preview" class="d-flex flex-wrap gap-3 mt-3"></div>
                <div class="d-flex justify-content-between pt-6 border-top">
                    <a href="{{ route('buyer.seller.informasi_toko') }}" class="btn btn-secondary px-8">Kembali</a>
                    <button type="submit" class="btn btn-success px-8">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.getElementById('images').addEventListener('change', function(e) {
            const preview = document.getElementById('preview');
            preview.innerHTML = '';
            for (const file of e.target.files) {
                const reader = new FileReader();
                reader.onload = function(evt) {
                    const img = document.createElement('img');
                    img.src = evt.target.result;
                    img.classList.add('rounded-3', 'shadow-sm');
                    img.style.width = '120px';
                    img.style.height = '120px';
                    img.style.objectFit = 'cover';
                    preview.appendChild(img);
                };
                reader.readAsDataURL(file);
            }
        });
        init_form_element();
    </script>
@endpush
