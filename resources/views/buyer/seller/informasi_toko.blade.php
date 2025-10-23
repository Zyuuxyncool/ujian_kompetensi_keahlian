@extends('buyer.layouts.index')

@section('title')
    Informasi Toko -
@endsection

@section('content')
    <div class="container py-10">
        {{-- HEADER DAN TOMBOL SIMPAN (SAMA) --}}
        <div class="d-flex justify-content-between align-items-center mb-6">
            {{-- PERBAIKAN 1: Tambahkan route ke halaman Verifikasi Data Diri (Langkah 1) --}}
            <a href="{{ route('buyer.seller.verify') }}" class="text-dark fs-3 fw-bold">
                <i class="fas fa-arrow-left me-2"></i> {{-- Ikon kembali --}}
            </a>
            <h1 class="fs-2 fw-bold m-0">Informasi Toko</h1>
            <button class="btn btn-sm btn-link text-danger fw-bold">Simpan</button>
        </div>

        {{-- NAVIGATION STEPPER (SAMA) --}}
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
                <span class="d-inline-block bg-secondary rounded-circle" style="width:10px;height:10px;"></span>
                <div class="text-gray-400 fw-bold mt-2">Upload Produk</div>
            </div>
        </div>

        {{-- CARD FORM CONTENT --}}
        <div class="card shadow-sm border-0">
            <div class="card-body p-8">
                <form action="{{ route('buyer.seller.informasi_toko.store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="input_latitude" name="latitude" value="{{ $profil->latitude ?? '' }}">
                    <input type="hidden" id="input_longitude" name="longitude" value="{{ $profil->longitude ?? '' }}">

                    <div class="mb-8">
                        <label class="form-label fs-5 fw-bold">Username <span class="text-danger">*</span></label>
                        <x-input name="username" caption="Username" :value="$profil->username ?? ''" />
                    </div>

                    <div class="mb-8">
                        <label class="form-label fs-5 fw-bold">Nama Toko <span class="text-danger">*</span></label>
                        <x-input name="nama_toko" caption="Nama Toko" :value="$profil->nama_toko ?? ''" />
                    </div>

                    <div class="mb-8">
                        <label class="form-label fs-5 fw-bold">Nomer Telepon</label>
                        <x-input name="no_telp" caption="No Telp" :value="$profil->notlp ?? ''" />
                    </div>
                    <div class="mb-8">
                        <label class="form-label fs-5 fw-bold">Alamat Lengkap</label>
                        <x-textarea name="alamat" caption="Alamat Lengkap" :value="$profil->alamat ?? ''" />
                    </div>

                    <div class="mb-8">
                        <label class="form-label fs-5 fw-bold">Provinsi</label>
                        <x-select name="provinsi" caption="Provinsi" :value="$profil->provinsi ?? ''" />
                    </div>

                    <div class="mb-8">
                        <label class="form-label fs-5 fw-bold">Kota/Kabupaten</label>
                        <x-select name="kabupaten" caption="Kabupaten" :value="$profil->kabupaten ?? ''" />
                    </div>

                    <div class="mb-8">
                        <label class="form-label fs-5 fw-bold">Kecamatan</label>
                        <x-select name="kecamatan" caption="Kecamatan" :value="$profil->kecamatan ?? ''" />
                    </div>
                    <div class="mb-8">
                        <label class="form-label fs-5 fw-bold">Kelurahan/Desa</label>
                        <x-select name="desa" caption="Desa" :value="$profil->desa ?? ''" />
                    </div>
                    @error('latitude')
                        <div class="alert alert-danger mb-3">{{ $message }}</div>
                    @enderror

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
                    <div class="d-flex justify-content-between pt-6 border-top">
                        <a href="{{ route('buyer.seller.verify') }}" class="btn btn-secondary px-8">Kembali</a>
                        <button type="submit" class="btn btn-success px-8">Lanjut</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
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
