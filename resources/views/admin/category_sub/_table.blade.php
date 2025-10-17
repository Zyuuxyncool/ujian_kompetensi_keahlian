<div class="table-responsive">
    <table class="table align-middle table-row-dashed fs-6 table-sm">
        <thead>
        <tr class="text-start bg-secondary text-dark fw-bold fs-7 text-uppercase border-bottom-0">
            <th class="w-10px ps-4 rounded-start">#</th>
            <th>Nama</th>
            <th>Photo</th>
            <th class="text-center w-50px pe-4 rounded-end">Aksi</th>
        </tr>
        </thead>
        <tbody class="">
        @php($no = 1)
        @if($category_subs instanceof \Illuminate\Pagination\LengthAwarePaginator)
            @php($no = (($category_subs->currentPage()-1) * $category_subs->perPage()) + 1)
        @endif
        @foreach($category_subs as $category_sub)
            <tr>
                <td class="ps-4">{{ $no++ }}</td>
                <td>{{ $category_sub->name }}</td>
                <td class="py-0 align-middle">
                    <img src="{{ Storage::url($category_sub->photo) }}" alt="" class="h-30px w-30px object-fit-cover" />
                </td>
                <td class="text-end text-nowrap">
                    <button class="btn btn-sm btn-secondary ps-7" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Action <i class="ki-duotone ki-down fs-5 ms-1"></i>
                    </button>
                    <div class="menu menu-sub menu-sub-dropdown dropdown-menu menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-auto py-4" data-kt-menu="true">
                        <div class="menu-item px-3"><a onclick="info({{ $category_sub->id }})" href="javascript:void(0)" class="menu-link px-3">Edit</a></div>
                            <div class="menu-item px-3"><a onclick="confirm_delete({{ $category_sub->id }})" href="javascript:void(0)" class="menu-link px-3">Delete</a></div>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<div class="d-flex flex-row justify-content-center">
    @if($category_subs instanceof \Illuminate\Pagination\LengthAwarePaginator)
        {{ $category_subs->links('vendor.pagination.custom') }}
    @endif
</div>
