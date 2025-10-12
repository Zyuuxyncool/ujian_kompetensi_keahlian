@php($notifications = $notifications ?? [])
@auth
    <div class="d-flex align-items-center ms-1 ms-lg-2">
        <!-- Notifikasi -->
        <div class="btn btn-icon btn-active-light position-relative"
            data-kt-menu-trigger="click"
            data-kt-menu-attach="parent"
            data-kt-menu-placement="bottom-end">

        <ion-icon name="notifications-outline" class="text-success" style="font-size: 24px;"></ion-icon>


            @if(count($notifications) > 0)
                <span class="position-absolute top-0 start-100 translate-middle badge badge-circle bg-danger fs-8">
                    {{ count($notifications) }}
                </span>
            @endif
        </div>

        <!-- Dropdown isi notifikasi -->
        <div class="menu menu-sub menu-sub-dropdown menu-column w-350px w-lg-500px"
            data-kt-menu="true" id="kt_menu_notifications">
            <div class="d-flex flex-column" role="tabpanel">
                <div class="scroll-y mh-325px my-5 px-8">
                    @if(count($notifications) == 0)
                        <div class="text-center my-10"><i> - No new notification - </i></div>
                    @endif

                    @foreach($notifications as $notification)
                        @if($notification->flag === 0)
                            <div class="d-flex flex-stack py-4 border-bottom">
                                <div class="d-flex align-items-center">
                                    <div class="mb-0 me-2">
                                        <a href="#" class="fs-6 text-gray-800 text-hover-primary fw-bold">{{ $notification->title }}</a>
                                        <div class="text-gray-400 fs-7">{{ $notification->content }}</div>
                                    </div>
                                </div>
                                <span class="badge badge-light fs-8">{{ $notification->created_at }}</span>
                            </div>
                        @endif
                    @endforeach
                </div>

                @if(count($notifications) > 0)
                    <div class="py-3 text-center border-top">
                        <a href="{{ has_route('notification') }}" class="btn btn-color-gray-600 btn-active-color-primary">
                            View All
                            <ion-icon name="chevron-forward-outline" class="fs-5"></ion-icon>
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endauth
