@php($cart_items = $cart_items ?? [])
@auth

    <div class="d-flex align-items-center ms-1 ms-lg-2">
        <!-- Cart Icon -->
        <div class="btn btn-icon btn-active-light btn-active-color-success w-30px h-30px w-md-40px h-md-40px position-relative"
            data-kt-menu-trigger="click" data-kt-menu-attach="parent" data-kt-menu-placement="bottom-end">
            <ion-icon name="cart-outline" class="text-success" style="font-size: 25px"></ion-icon>

            @if (count($cart_items) > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge badge-circle bg-danger fs-8">
                    {{ count($cart_items) }}
                </span>
            @endif
        </div>


        <!-- Cart Dropdown -->
        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-450px" data-kt-menu="true" id="kt_menu_cart">
            <div class="d-flex flex-column" role="tabpanel">
                <div class="scroll-y mh-325px my-5 px-8">
                    @if (count($cart_items) == 0)
                        <div class="text-center my-10"><i> - No items in cart - </i></div>
                    @endif

                    @foreach ($cart_items as $item)
                        <div class="d-flex flex-stack py-4 border-bottom">
                            <div class="d-flex align-items-center">
                                <!-- Gambar Produk -->
                                <div class="symbol symbol-40px me-3">
                                    <img src="{{ $item->image ?? asset('images/default-product.png') }}"
                                        alt="{{ $item->name }}">
                                </div>
                                <!-- Detail Produk -->
                                <div class="mb-0">
                                    <a href="#"
                                        class="fs-6 text-gray-800 text-hover-primary fw-bold">{{ $item->name }}</a>
                                    <div class="text-gray-400 fs-7">
                                        Qty: {{ $item->quantity }} × Rp{{ number_format($item->price, 0, ',', '.') }}
                                    </div>
                                </div>
                            </div>
                            <span
                                class="fw-semibold text-gray-800">Rp{{ number_format($item->quantity * $item->price, 0, ',', '.') }}</span>
                        </div>
                    @endforeach
                </div>

                @if (count($cart_items) > 0)
                    <!-- Footer -->
                    <div class="py-3 text-center border-top">
                        <a href="{{ has_route('cart') }}" class="btn btn-color-gray-600 btn-active-color-primary">
                            View Cart
                            <ion-icon name="arrow-forward-outline" class="fs-5"></ion-icon>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endauth
