<div id="kt_header" class="header border-bottom-0 shadow-sm">
    <div class="container-fluid d-flex align-items-center justify-content-between py-3 px-lg-8">

        {{-- === Logo / Brand === --}}
        {{-- Kiri: Tetap berukuran alami --}}
        <div class="d-flex align-items-center gap-3">
            @if (count($current_side_menu ?? []) > 0)
                <button class="btn btn-icon btn-active-icon-primary d-lg-none" id="kt_aside_toggle">
                    <i class="ki-duotone ki-abstract-14 fs-2">
                        <span class="path1"></span><span class="path2"></span>
                    </i>
                </button>
            @endif
            <a href="{{ url('/buyer/landing') }}" class="text-decoration-none">
                <h1 class="header-title mb-0">Nusantara <span class="text-siap">Store</span></h1>
            </a>
        </div>

        {{-- === Search Bar (Tengah Fix) === --}}
        {{-- Kunci: 
           1. Hapus margin-left: 250px manual.
           2. Gunakan mx-auto untuk menengahkan di sisa ruang.
           3. Tambahkan flex-shrink-0 pada search bar agar tidak ikut menyusut.
        --}}
        <div class="d-none d-lg-flex flex-grow-1 justify-content-center mx-auto flex-shrink-0">
            <form action="" method="GET" style="max-width: 550px;" class="w-100">
                <div
                    class="input-group nusantara-search rounded-pill overflow-hidden border border-success shadow-elevated">
                    <input type="text" name="q" class="form-control border-0 ps-4 py-2" id="search_input"
                        placeholder="Cari produk, toko, atau kategori..." aria-label="Search" required>
                    <button type="submit"
                        class="btn btn-nusantara-icon d-flex align-items-center justify-content-center px-4"
                        style="background-color: #4CAF50;">
                        <i class="fa fa-search fs-5 text-white"></i>
                    </button>
                </div>
            </form>
        </div>

        {{-- === Menu kanan (notif, user, login) === --}}
        {{-- Kanan: Tetap berukuran alami --}}
        <div class="d-flex align-items-center gap-4 flex-shrink-0">
            {{-- <div class="d-flex align-items-stretch ms-6" id="kt_header_nav"> --}}
            {{-- @include('admin.layouts._menu') --}}
            {{-- </div> --}}
            @guest
                <a href="{{ route('login') }}"
                    class="btn btn-outline btn-actiwebve-success border-success btn-sm fs-6 px-6 py-2"
                    style="border-width: 2px">
                    Login / Register
                </a>
            @endguest

            @auth
                @include('buyer.layouts._cart')
                @include('buyer.layouts._notification')
                @include('buyer.layouts._user')
            @endauth

            {{-- Mobile toggle --}}
            {{-- <button class="btn btn-icon btn-active-light-primary d-lg-none" id="kt_header_menu_mobile_toggle">
                <i class="ki-duotone ki-text-align-left fs-2 fw-bold">
                    <span class="path1"></span><span class="path2"></span>
                    <span class="path3"></span><span class="path4"></span>
                </i>
            </button> --}}
        </div>

    </div>
</div>
<script>
    $(function() {
    // Inisialisasi fungsi autocomplete pada input dengan id 'search_input'
    $("#search_input").autocomplete({
        // Gunakan route name yang sudah didefinisikan di Canvas (routes/web.php)
        source: "{{ route('search.autocomplete') }}", 
        
        // Mulai memanggil AJAX setelah 3 karakter diketik
        minLength: 3,   
        
        // Jeda 300ms sebelum request AJAX dikirim (untuk menghindari spam request)
        delay: 300,     
        
        // Handler ketika pengguna memilih saran dari daftar
        select: function(event, ui) {
            // 'ui.item' berisi data {id, label, value} dari Controller
            
            // Set input dengan nilai yang dipilih
            $(this).val(ui.item.value);
            
            // Kirim form pencarian untuk menampilkan hasil
            $(this).closest('form').submit(); 

            return false;
        }
    });
});

</script>