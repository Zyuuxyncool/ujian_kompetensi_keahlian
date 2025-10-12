<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title') {{ env('APP_NAME') }}</title>
    <meta charset="utf-8" />
    <meta name="description" content="" />
    <meta name="keywords" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <link rel="shortcut icon" href="{{ asset('assets2/img/logo/favicon.png') }}" type="image/png" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" />
    @stack('plugins')
    {{--    <link href="{{ asset('assets/plugins/global/plugins.bundle.css') }}" rel="stylesheet" type="text/css" />--}}
    {{--    <link href="{{ asset('assets/css/style.bundle.css') }}" rel="stylesheet" type="text/css" />--}}
    <style>
        @page {
            size: A5;
            margin: 1cm; /* or adjust as needed */
        }
        body {
            width: 148mm;
            height: 210mm;
            margin: auto;
            padding: 20mm;
            background: white;
        }
        .table {
            width: 100%;
            border-spacing: 0;
        }
        tr td {
            padding: 5px 10px;
        }
        .text-center {
            text-align: center!important;
        }
        .text-nowrap {
            white-space: nowrap!important;
        }
        .text-end {
            text-align: right!important;
        }
        .float-start {
            float: left!important;
        }
        .mb-0 {
            margin-bottom: 0!important;
        }
        h3 {
            margin-bottom: 5px;
            margin-top: 5px;
        }
        h5 {
            margin-bottom: 5px;
            margin-top: 5px;
        }
        p {
            margin-top: 0;
        }
        .fw-bolder {
            font-weight: bolder;
        }
        .fs-3 {
            font-size: 16pt;
        }
        .w-30px {
            width: 30px!important;
        }
        .my-1 {
            margin-top: 1px;
            margin-bottom: 1px;
        }
        .border {
            border: 1px solid #000;
        }
        .image-input {
            background-position: center;
            background-size: contain;
        }
        .image-input .image-input-wrapper {
            background-size: contain;
        }
        .symbol>img {
            width: auto!important;
        }
        .form-select {
            padding: .825rem 1.5rem;
        }
        .card {
            background-color: rgba(245,248,250,.15);
        }
        .form-control. {
            background-color: #e0e0e0;
        }
        .form-select. {
            background-color: #e0e0e0;
        }
        @media print {
            .page-break {page-break-after: always!important;}
        }
    </style>
    @stack('styles')
</head>
<body id="kt_body" class="header-fixed header-tablet-and-mobile-fixed toolbar-enabled">

<div class="d-flex flex-column flex-root">
    <div class="page d-flex flex-row flex-column-fluid">
        <div class="wrapper d-flex flex-column flex-row-fluid p-20" id="kt_wrapper">

            @yield('content')

        </div>
    </div>
</div>


@stack('modals')

<script>let hostUrl = "{{ asset('assets') }}/";</script>
@stack('scripts')
</body>
</html>
