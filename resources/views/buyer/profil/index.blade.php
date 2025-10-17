@extends('buyer.layouts.index')

@section('title')
    Profil -
@endsection

@section('body-class')
    bg-light-secondary
@endsection

@section('content')
    <section class="container py-20">
        <div class="d-flex flex-row align-items-stretch gap-4">
            <div class="bg-success w-7px rounded-top rounded-bottom">&nbsp;</div>
            <h2 class="fs-2x m-0 my-1">Profil {{ $profil->nama }}</h2>
        </div>

        <form action="{{ route('buyer.profil.update') }}" method="post" enctype="multipart/form-data">
            @csrf
            <div class="card border-0 shadow-sm mt-6">
                <div class="card-body">
                    <div class="d-flex flex-row gap-6">
                        <div class="flex-grow-1">
                            <input type="hidden" name="latitude" id="input_latitude" value="{{ $profil->latitude ?? '' }}">
                            <input type="hidden" name="longitude" id="input_longitude"
                                value="{{ $profil->longitude ?? '' }}">
                            <x-metronic-input name="nama" caption="Nama" :value="$profil->nama ?? ''" />
                            <x-metronic-select name="jenis_kelamin" caption="Jenis Kelamin" :options="gender()"
                                :value="$profil->jenis_kelamin ?? ''" />
                            <x-metronic-input name="tanggal_lahir" caption="Tanggal Lahir" class="datepicker"
                                :value="format_date($profil->tanggal_lahir ?? '')" />
                            <x-metronic-input name="notelp" caption="No.Telp/Whatsapp" class="only-numeric"
                                :value="$profil->notelp ?? ''" />
                            <x-metronic-textarea name="alamat" caption="Alamat Lengkap" :value="$profil->alamat ?? ''" />
                            <x-metronic-select name="provinsi" caption="Provinsi" :value="$profil->provinsi ?? ''" />
                            <x-metronic-select name="kabupaten" caption="Kabupaten" :value="$profil->kabupaten ?? ''" />
                            <x-metronic-select name="kecamatan" caption="Kecamatan" :value="$profil->kecamatan ?? ''" />
                            <x-metronic-select name="desa" caption="Desa" :value="$profil->desa ?? ''" />
                            <x-metronic-input name="email" caption="Email" :value="$profil->user->email ?? ''" />
                        </div>
                        <div class="w-lg-200px w-100">
                            <div class="alert alert-danger d-flex align-items-center p-5 mt-5 d-none w-100"
                                @error('file_foto') style="display: block!important;" @enderror id="file_foto_error">
                                <div class="d-flex flex-column align-items-start" id="file_foto_error_content">
                                    @error('file_foto')
                                        <span>{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="d-none"><x-input type="file" name="file_foto" alert="0" /><x-input
                                    name="delete_foto" alert="0" /></div>
                            <img src="{{ $profil->photo ? Storage::url($profil->photo) : asset('images/user_menubar.jpg') }}"
                                id="preview_foto" alt="Foto Profil"
                                class="w-100 h-auto object-fit-cover shadow-xs rounded-1" />
                            <button class="btn btn-secondary btn-sm py-4 fs-8 mt-3 w-100" type="button"
                                onclick="open_file('file_foto', 'preview_foto')">Ubah Foto (jpg/png/jpeg)</button>
                        </div>
                    </div>
                    <div class="position-relative mt-6">
                        @if ($profil->latitude && $profil->longitude)
                            {{-- Menggunakan format embed standar dengan koordinat $profil --}}
                            <iframe id="map_iframe"
                                src="https://www.google.com/maps/embed/v1/view?key=API_KEY&center=lat,lon{{ $profil->latitude }},{{ $profil->longitude }}&z=15&output=embed"
                                width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                            <a target="_blank" id="map_link"
                                href="https://maps.google.com/?q={{ $profil->latitude }},{{ $profil->longitude }}"
                                class="btn btn-sm btn-primary fw-semibold position-absolute ms-3 mt-3"
                                style="left: 0; top: 0;">Buka Google Maps</a>
                        @else
                            {{-- Peta default (misal pusat kota Sidoarjo) --}}
                            <iframe id="map_iframe" src="https://maps.google.com/maps?q=Indonesia&z=5&output=embed"
                                width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                            <a target="_blank" id="map_link" href="#"
                                class="btn btn-sm btn-secondary fw-semibold position-absolute ms-3 mt-3"
                                style="left: 0; top: 0;">Lokasi Belum Tersedia</a>
                        @endif

                        {{-- TOMBOL UNTUK MENDAPATKAN LOKASI PENGGUNA --}}
                        <button id="get_location_btn" type="button"
                            class="btn btn-info fw-semibold position-absolute ms-3 mt-3" style="right: 0; top: 0;">
                            <i class="fas fa-location-arrow me-2"></i> Dapatkan Lokasi Saya
                        </button>
                    </div>
                </div>
                <div class="card-footer d-flex justify-content-end py-6">
                    <button type="submit" class="btn btn-success">Simpan Profil</button>
                </div>
            </div>
        </form>
    </section>
@endsection
@push('scripts')
    <script>
        init_form_element()

        $provinsi = $('#provinsi');
        $kabupaten = $('#kabupaten');
        $kecamatan = $('#kecamatan');
        $desa = $('#desa');

        get_location($provinsi, 1, '', '{{ $profil->provinsi ?? '' }}');
        $provinsi.change(() => {
            let id = $provinsi.find('option:selected').attr('data-id');
            get_location($kabupaten, 2, id, '{{ $profil->kabupaten ?? '' }}');
        });
        $kabupaten.change(() => {
            let id = $kabupaten.find('option:selected').attr('data-id');
            get_location($kecamatan, 3, id, '{{ $profil->kecamatan ?? '' }}');
        });
        $kecamatan.change(() => {
            let id = $kecamatan.find('option:selected').attr('data-id');
            get_location($desa, 4, id, '{{ $profil->desa ?? '' }}');
        });

        const $latInput = $('#input_latitude');
        const $lonInput = $('#input_longitude');
        const $mapIframe = $('#map_iframe');
        const $mapLink = $('#map_link');
        const $locButton = $('#get_location_btn');

        // Fungsi untuk memperbarui tampilan peta setelah koordinat baru didapat
        function updateMap(lat, lon) {
            // ⭐ PERBAIKAN: Menggunakan ${lat} dan ${lon}
            const embedUrl = `https://maps.google.com/maps?q=${lat},${lon}&z=15&output=embed`;
            const mapUrl = `https://www.google.com/maps/search/?api=1&query=$${lat},${lon}`;

            $mapIframe.attr('src', embedUrl);
            $mapLink.attr('href', mapUrl).text('Buka Google Maps').removeClass('btn-secondary').addClass('btn-primary');
        }

        // Fungsi utama untuk mendapatkan lokasi dari browser
        function getBrowserLocation() {
            // ... (Fungsi ini tidak diubah dan sudah benar) ...
            if (navigator.geolocation) {
                $locButton.html('<span class="spinner-border spinner-border-sm me-2"></span> Mencari Lokasi...');
                $locButton.prop('disabled', true);

                navigator.geolocation.getCurrentPosition(
                    // Success
                    (position) => {
                        const lat = position.coords.latitude;
                        const lon = position.coords.longitude;

                        // 1. ISI INPUT TERSEMBUNYI (Data akan dikirim saat form disubmit)
                        $latInput.val(lat);
                        $lonInput.val(lon);

                        // 2. PERBARUI TAMPILAN PETA SECARA INSTAN
                        updateMap(lat, lon);

                        $locButton.html('<i class="fas fa-check me-2"></i> Lokasi Ditemukan!');
                        setTimeout(() => {
                            $locButton.html('<i class="fas fa-location-arrow me-2"></i> Dapatkan Lokasi Saya');
                            $locButton.prop('disabled', false);
                        }, 3000);

                        console.log(`Lokasi Baru: Lat ${lat}, Lon ${lon}`);
                    },
                    // Error
                    (error) => {
                        $locButton.html('<i class="fas fa-times me-2"></i> Gagal! Coba Lagi');
                        $locButton.prop('disabled', false);
                        let msg = (error.code === 1) ? 'Akses Lokasi Ditolak.' : 'Gagal mendapatkan lokasi.';
                        alert(`Error: ${msg}`);
                        console.warn(`Error Lokasi (${error.code}): ${error.message}`);
                    }, {
                        enableHighAccuracy: true,
                        timeout: 10000,
                        maximumAge: 0
                    }
                );
            } else {
                alert("Browser Anda tidak mendukung Geolocation API.");
            }
        }

        // Panggil fungsi saat tombol ditekan
        $locButton.on('click', getBrowserLocation);
    </script>
@endpush
