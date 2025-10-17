<form id="form_info">
    @csrf
    <div class="modal-header">
        <div class="card-title fs-3 fw-bold">{{ !empty($category_sub) ? 'Ubah' : 'Tambah' }} Cetegory</div>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col-lg-10">
                @if (empty($category_sub))
                    <x-metronic-select name="category_id" caption="Cetegory" :options="$list_category" :value="$category_sub->name ?? ''" />
                @endif
                <x-metronic-input name="name" caption="Nama" :value="$category_sub->name ?? ''" />
            </div>
            <div class="col-lg-2">
                <div class="alert alert-danger d-flex align-items-center p-5 mt-5 d-none w-100"
                    @error('file_foto') style="display: block!important;" @enderror id="file_foto_error">
                    <div class="d-flex flex-column align-items-start" id="file_foto_error_content">
                        @error('file_foto')
                            <span>{{ $message }}</span>
                        @enderror
                    </div>
                </div>
                <div class="d-none"><x-input type="file" name="file_photo" alert="0"
                        /><x-inputname="delete_foto" alert="0" /></div>
                <img src="{{ ($category_sub->photo ?? '') != '' ? Storage::url($category_sub->photo) : asset('images/default.jpg') }}"
                    id="preview_foto" alt="" class="w-100 h-auto object-fit-cover shadow-xs rounded-1" />
                <div class="d-flex flex-column gap-1">
                    <button class="btn btn-secondary btn-sm py-2 mt-3 fs-8"
                        type="button"onclick="open_file('file_photo', 'preview_foto')">Cari Foto</button>
                    <button class="btn btn-secondary btn-sm py-2 mt-3 fs-8"
                        type="button"onclick="remove_file('delete_foto', 'preview_foto', '{{ asset('images/default.jpg') }}')">Hapus
                        Foto</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal-footer d-flex justify-content-end py-6">
        <button type="button" onclick="init()" class="btn btn-light btn-active-light-primary me-2">Batal</button>
        <button type="submit" class="btn btn-primary">Simpan</button>
    </div>
</form>

<script>
    init_form_element();
    init_form({{ $category_sub->id ?? '' }});
</script>
