<form id="form_info" enctype="multipart/form-data" data-product-id="{{ $product->id ?? '' }}">
    @csrf
    <div class="modal-header">
        <div class="card-title fs-3 fw-bold">{{ !empty($product) ? 'Ubah' : 'Tambah' }} Produk</div>
    </div>

    <div class="modal-body">
        <div class="row">
            <div class="col-lg-12">

                <div class="mb-4">
                    <label for="name" class="form-label fw-bold">Nama Produk</label>
                    <x-input name="name" caption="Nama" :value="$product->name ?? old('name')" required />
                </div>

                <div class="mb-4">
                    <label for="description" class="form-label fw-bold">Deskripsi Produk</label>
                    <textarea name="description" id="description" class="form-control form-control-lg" rows="4"
                        placeholder="Tulis deskripsi produk...">{{ $product->description ?? old('description') }}</textarea>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="price" class="form-label fw-bold">Harga (Rp)</label>
                        <x-input name="price" caption="price" :value="$product->price ?? old('price')" required class="autonumeric"
                            data-unformat="true" />
                    </div>

                    <div class="col-md-6 mb-4">
                        <label for="stock" class="form-label fw-bold">Stok</label>
                        <x-input name="stock" caption="stock" :value="$product->stock ?? old('stock')" required class="autonumeric" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-4">
                        <label for="sub_category_id" class="form-label fw-bold">Sub Kategori</label>
                        @php
                            $selectedSubCategory = $product->sub_category_id ?? old('sub_category_id');
                        @endphp
                        <x-select name="sub_category_id" prefix="search_" :options="$list_sub_categories ?? []" class="form-select"
                            :value="$selectedSubCategory" data-control="select2" />
                    </div>

                    {{-- Brand --}}
                    <div class="col-md-6 mb-4">
                        <label for="brand_id" class="form-label fw-bold">Brand</label>
                        @php
                            $selectedBrand = $product->brand_id ?? old('brand_id');
                        @endphp
                        <x-select name="brand_id" prefix="search_" :options="$list_brands ?? []" class="form-select"
                            :value="$selectedBrand" data-control="select2" />
                    </div>
                </div>

                <div class="mb-4">
                    <label for="images" class="form-label fw-bold">Foto Produk</label>
                    <input type="file" id="images" class="form-control form-control-lg" accept="image/*" multiple>

                    <small class="text-muted d-block mt-1">
                        Anda dapat menambahkan beberapa foto sekaligus atau satu per satu (maks. 2MB per file).
                    </small>

                    <div id="preview-images" class="d-flex flex-wrap gap-3 mt-3">
                        @if (!empty($product) && $product->images)
                            @foreach ($product->images as $img)
                                <div class="position-relative preview-item" data-image-id="{{ $img->id }}"
                                    style="width: 90px; height: 90px;">
                                    <img src="{{ Storage::url($img->photo) }}" data-id="{{ $img->id }}"
                                        data-existing="true" class="rounded shadow-sm"
                                        style="object-fit: cover; width: 100%; height: 100%;" alt="Preview">
                                    <button type="button"
                                        class="btn btn-sm btn-danger position-absolute top-0 end-0 rounded-circle remove-existing-image"
                                        style="width: 22px; height: 22px; padding: 0;">
                                    </button>
                                </div>
                            @endforeach
                        @endif
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="modal-footer d-flex justify-content-end py-6">
        <button type="button" onclick="init()" class="btn btn-light btn-active-light-primary me-2">Batal</button>
        <button type="submit" class="btn btn-primary" id="submitButton">Simpan</button>
    </div>
</form>

{{-- Script --}}
<script>
    init_form_element();
    init_product_form();
    // init_form({{ $product->id ?? '' }});
</script>
