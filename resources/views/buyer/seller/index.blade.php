@extends('buyer.layouts.index')

@section('title')
    Profil -
@endsection

@section('content')
    <section class="container py-20">
        <div class="card border-0 shadow-sm text-center py-20">
            <div class="d-flex flex-column align-items-center justify-content-center">
                <div class="bg-light-primary rounded-circle d-flex align-items-center justify-content-center mb-8"
                    style="width: 150px; height: 150px;">
                    <i class="ki-outline ki-shop fs-4x text-primary"></i>
                </div>

                <h2 class="fw-bold fs-2x mb-3">Aktifkan Akun Seller Anda</h2>
                <p class="text-muted fs-6 mb-10 w-lg-50 mx-auto">
                    Mulai jual produkmu dan kelola tokomu dengan mudah.
                    Klik tombol di bawah untuk mengaktifkan akun seller sekarang!
                </p>

                <a href="javascript:void(0)" onclick="confirm_verify()" class="btn btn-success px-10 py-4 fs-6 fw-bold">
                    Aktifkan Sekarang
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        function confirm_verify() {
            Swal.fire({
                title: 'Aktifkan Akun Seller?',
                text: "Kamu akan diarahkan ke halaman verifikasi seller.",
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Ya, lanjutkan',
                cancelButtonText: 'Batal',
                reverseButtons: true,
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-secondary'
                },
                buttonsStyling: false
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('buyer.seller.verify') }}";
                }
            });
        }
    </script>
@endpush
