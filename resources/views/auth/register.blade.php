@extends('admin.layouts.layout')

@section('title')
    Register -
@endsection

@section('body-class')
    auth-bg
@endsection

@push('styles')
    <style>
        body {
            background: url('{{ asset('images/bg-login.jpg') }}') no-repeat center;
            background-size: cover;
        }

        [data-bs-theme="dark"] body {
            background: url('{{ asset('images/bg-login.jpg') }}') no-repeat center;
            background-size: cover;
        }
    </style>
@endpush

@section('body')
    <div class="d-flex flex-column flex-center flex-column-fluid">
        <div class="d-flex flex-column flex-center p-10">
            <div class="card card-flush w-lg-800px py-5">
                <div class="card-body py-15 py-lg-10">
                    <form action="{{ route('register.proses', ['role' => $role]) }}" method="post">
                        @csrf
                        <x-input type="hidden" name="role" :value="$role" />
                        <div class="text-center">
                            <a href="{{ url('/') }}" class=""><img alt="Logo" src="{{ asset('images/logo.png') }}" class="h-40px mb-6"/></a>
                            <h1 class="fw-bolder text-gray-900 mb-2">Daftar Akun</h1>
                            <div class="fs-6 fw-semibold text-gray-500 mb-10">Daftar akun untuk mulai menggunakan {{ env('APP_NAME') }}</div>
                        </div>

                        <div class="w-100 mb-6 px-10">
                            @if($role === 'Masyarakat')
                                <x-metronic-input name="nik" type="text" class="only-numeric" caption="NIK" placeholder="NIK / Nomor KTP" class="only-numeric" :value="old('nik')" maxLength="16" minLength="16" />
                                <x-metronic-input name="nama" type="text" caption="Nama Lengkap" placeholder="Nama Sesuai KTP" :value="old('nama')" />
{{--                                <p style="color: red;">Jika NIK anda "HAS ALREADY BEEN TAKEN" maka silahkan pakai lupa password dibawah ini</p>--}}
                            @else
                                <x-metronic-input name="nama" type="text" caption="Nama Perusahaan" placeholder="Nama Perusahaan" :value="old('nama')" />
                                <x-metronic-input name="sektor" type="text" caption="Sektor Perusahaan" placeholder="Sektor Perusahaan" :value="old('sektor')" />
                            @endif
                            <x-metronic-input name="notelp" type="text" caption="No.Telp" class="only-numeric" placeholder="Ada Whatsapp Aktif" :value="old('notelp')" />
                            <x-metronic-input name="email" type="text" caption="Email" placeholder="Email" :value="old('email')" />
                            <x-metronic-input name="password" type="password" caption="Password" placeholder="Password" />
                            <x-metronic-input name="password_confirmation" type="password" caption="Ulangi Password" placeholder="Ulangi password, agar tidak salah ketik" />

                            @if($role === 'Perusahaan')
                                <p>Akun dan profil perusahaan yang anda register, akan divalidasi oleh BIDANG PENTA - DISNAKER KAB. SIDOARJO, dan diharapkan datang ke kantor BIDANG PENTA - DISNAKER KAB. SIDOARJO pada jam kerja</p>
                            @endif
                        </div>

                        <div class="d-flex flex-column mx-lg-10 mb-6">
                            <button type="submit" class="btn btn-primary mb-3 ps-8">
                                <i class="ki-duotone ki-entrance-left fs-3 me-0 ms-1"><span class="path1"></span><span class="path2"></span></i>
                                Daftar
                            </button>
                        </div>

                        <div class="px-10 mb-8"><hr></div>

                        <div class="px-10 d-flex flex-column gap-8">
                            <a href="{{ route('login') }}" class="text-dark fw-bold fs-4 d-flex flex-row justify-content-center align-items-center gap-4">
                                <div class="w-20px"></div>
                                <p class="my-0 lh-0">Sudah Punya Akun? Login</p>
                                <img src="{{ asset('images/ic_right.png') }}" alt="" class="h-20px w-20px">
                            </a>
                            <a href="{{ route('forgot_password') }}" class="text-dark fw-bold fs-4 d-flex flex-row justify-content-center align-items-center gap-4">
                                <p style="color: red;">Lupa Password Pelamar Kerja</p>
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        init_form_element()
    </script>
@endpush
