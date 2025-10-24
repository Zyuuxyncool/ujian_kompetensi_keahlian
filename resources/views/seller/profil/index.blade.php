@extends('admin.layouts.index')

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
            <h2 class="fs-2x m-0 my-1">Profil {{ $profil->nama_toko }}</h2>
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
                            <x-metronic-input name="nama" caption="Nama Toko" :value="$profil->nama_toko ?? ''" />
                            <x-metronic-input name="username" caption="Username" :value="$profil->username ?? ''" />
                            {{-- <x-metronic-select name="jenis_kelamin" caption="Jenis Kelamin" :options="gender()"
                                :value="$profil->jenis_kelamin ?? ''" /> --}}
                            {{-- <x-metronic-input name="tanggal_lahir" caption="Tanggal Lahir" class="datepicker"
                                :value="format_date($profil->tanggal_lahir ?? '')" /> --}}
                            <x-metronic-input name="notlp" caption="No.Telp/Whatsapp" class="only-numeric"
                                :value="$profil->notlp ?? ''" />
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
                            <iframe id="map_iframe"
                                src="https://maps.google.com/maps?q={{ $profil->latitude }},{{ $profil->longitude }}&z=15&output=embed"
                                width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>

                            <a target="_blank" id="map_link"
                                href="https://www.google.com/maps/search/?api=1&query={{ $profil->latitude }},{{ $profil->longitude }}"
                                class="btn btn-sm btn-primary fw-semibold position-absolute ms-3 mt-3"
                                style="left: 0; top: 0;">Buka Google Maps</a>
                        @else
                            <iframe id="map_iframe" src="https://maps.google.com/maps?q=Indonesia&z=5&output=embed"
                                width="100%" height="350" style="border:0;" allowfullscreen="" loading="lazy"
                                referrerpolicy="no-referrer-when-downgrade"></iframe>
                            <a target="_blank" id="map_link" href="#"
                                class="btn btn-sm btn-secondary fw-semibold position-absolute ms-3 mt-3"
                                style="left: 0; top: 0;">Lokasi Belum Tersedia</a>
                        @endif

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
        init_form_element();

        // --- Elemen Lokasi ---
        const $provinsi = $('#provinsi');
        const $kabupaten = $('#kabupaten');
        const $kecamatan = $('#kecamatan');
        const $desa = $('#desa');

        // Inisialisasi dan logic dropdown lokasi Anda
        get_location($provinsi, 1, '', '{{ $profil->provinsi ?? '' }}');
        $provinsi.change(() => {
            const id = $provinsi.find('option:selected').attr('data-id');
            get_location($kabupaten, 2, id, '{{ $profil->kabupaten ?? '' }}');
        });
        $kabupaten.change(() => {
            const id = $kabupaten.find('option:selected').attr('data-id');
            get_location($kecamatan, 3, id, '{{ $profil->kecamatan ?? '' }}');
        });
        $kecamatan.change(() => {
            const id = $kecamatan.find('option:selected').attr('data-id');
            get_location($desa, 4, id, '{{ $profil->desa ?? '' }}');
        });

        // --- Elemen Peta & Geolocation ---
        const $latInput = $('#input_latitude');
        const $lonInput = $('#input_longitude');
        const $mapIframe = $('#map_iframe');
        const $mapLink = $('#map_link');
        const $locButton = $('#get_location_btn');

        let locationSuccessTimer;

        function updateMap(lat, lon) {
            // URL peta menggunakan format yang benar
            const embedUrl = `https://maps.google.com/maps?q=${lat},${lon}&z=15&output=embed`;
            const mapUrl = `https://www.google.com/maps/search/?api=1&query=${lat},${lon}`;

            $mapIframe.attr('src', embedUrl);
            $mapLink.attr('href', mapUrl).text('Buka Google Maps')
                .removeClass('btn-secondary').addClass('btn-primary');
        }

        function handleLocationError(errorMsg) {
            // Pastikan timer sukses dibersihkan jika error terjadi
            if (locationSuccessTimer) {
                clearTimeout(locationSuccessTimer);
            }

            // Reset input & iframe ke default
            $latInput.val('');
            $lonInput.val('');
            $mapIframe.attr('src', 'https://maps.google.com/maps?q=&z=15&output=embed'); // URL default
            $mapLink.attr('href', '#').text('Lokasi Belum Tersedia')
                .removeClass('btn-primary').addClass('btn-secondary');

            // Mengatur state tombol ke Error/Gagal
            $locButton.html('<i class="fas fa-times me-2"></i> Gagal! Coba Lagi');
            $locButton.prop('disabled', false);

            // MENGGANTI ALERT DENGAN SWEETALERT2
            Swal.fire({
                icon: 'error',
                title: 'Gagal Mendapatkan Lokasi',
                text: errorMsg,
                confirmButtonText: 'Tutup'
            });
            console.warn(`Error Lokasi: ${errorMsg}`);
        }

        function getBrowserLocation() {
            if (!navigator.geolocation) {
                // MENGGANTI ALERT DENGAN SWEETALERT2 UNTUK KASUS BROWSER TIDAK SUPPORT
                Swal.fire({
                    icon: 'warning',
                    title: 'Browser Tidak Didukung',
                    text: 'Browser Anda tidak mendukung Geolocation API. Silakan update browser Anda.',
                    confirmButtonText: 'Oke'
                });
                return;
            }

            // Membersihkan timer lama jika tombol ditekan lagi
            if (locationSuccessTimer) {
                clearTimeout(locationSuccessTimer);
            }

            // Mengatur state tombol ke Mencari Lokasi...
            $locButton.html('<span class="spinner-border spinner-border-sm me-2"></span> Mencari Lokasi...');
            $locButton.prop('disabled', true);

            navigator.geolocation.getCurrentPosition(
                (position) => { // Success
                    if (!position || !position.coords) {
                        handleLocationError('Data lokasi tidak valid.');
                        return;
                    }

                    const lat = position.coords.latitude;
                    const lon = position.coords.longitude;

                    $latInput.val(lat);
                    $lonInput.val(lon);
                    updateMap(lat, lon);

                    // Mengatur state tombol ke Sukses
                    $locButton.html('<i class="fas fa-check me-2"></i> Lokasi Ditemukan!');

                    // Menyimpan ID timer untuk reset tombol otomatis
                    locationSuccessTimer = setTimeout(() => {
                        $locButton.html('<i class="fas fa-location-arrow me-2"></i> Dapatkan Lokasi Saya');
                        $locButton.prop('disabled', false);
                    }, 3000);

                    // console.log(`Lokasi Baru: Lat ${lat}, Lon ${lon}`);

                    // (Opsional: Swal sukses singkat)
                    Swal.fire({
                        icon: 'success',
                        title: 'Lokasi Berhasil Ditemukan!',
                        showConfirmButton: false,
                        timer: 1500,
                        toast: true,
                        position: 'top-end',
                    });

                },
                (error) => { // Error
                    let msg = '';
                    switch (error.code) {
                        case 1:
                            msg =
                                'Akses Lokasi Ditolak oleh pengguna. Mohon izinkan akses lokasi di pengaturan browser Anda.';
                            break;
                        case 2:
                            msg = 'Posisi tidak dapat ditentukan karena sumber lokasi tidak tersedia.';
                            break;
                        case 3:
                            msg = 'Waktu permintaan lokasi habis.';
                            break;
                        default:
                            msg = 'Terjadi kesalahan tidak terduga saat mengambil lokasi.';
                    }
                    // MEMANGGIL PENANGAN ERROR DENGAN SWEETALERT2
                    handleLocationError(msg);
                }, {
                    enableHighAccuracy: false,
                    timeout: 5000,
                    maximumAge: 0
                }
            );
        }

        $locButton.on('click', getBrowserLocation);
    </script>
@endpush
