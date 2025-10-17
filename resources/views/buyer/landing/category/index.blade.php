@extends('buyer.layouts.index')

@section('title')
    Kategori -
@endsection

@section('content')
    <div class="content flex-column-fluid" id="kt_content">
        {{-- Toolbar & Breadcrumb --}}
        <div class="toolbar d-flex flex-stack flex-wrap mb-5 mb-lg-7" id="kt_toolbar">
            <div class="page-title d-flex flex-column py-1 w-100 align-items-center">
                <h1 class="d-flex align-items-center my-1">
                    <span class="text-dark fw-bold fs-1">Kategori</span>
                </h1>
                <div class="breadcrumb-wrapper mt-1">
                    @include('buyer.layouts._breadcrumbs', ['breadcrumbs' => $breadcrumbs ?? []])
                </div>
            </div>
        </div>
    </div>
@endsection
