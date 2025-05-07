<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <link rel="shortcut icon" href="{{ asset('admin/assets/img/logos/' . ($settings && $settings->logo ? 'uploads/' . $settings->logo : 'default.jpg')) . '?v=' . time() }}" type="image/x-icon">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- ================== GOOGLE FONTS ==================-->
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500" rel="stylesheet">

    <!-- ======================= GLOBAL VENDOR STYLES ========================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/vendor/bootstrap.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/metismenu/dist/metisMenu.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/switchery-npm/index.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css') }}">

    <!-- ======================= LINE AWESOME ICONS ===========================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/icons/line-awesome.min.css') }}">

    <!-- ======================= DRIP ICONS ===================================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/icons/dripicons.min.css') }}">

    <!-- ======================= MATERIAL DESIGN ICONIC FONTS =================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/icons/material-design-iconic-font.min.css') }}">

    <!-- ======================= PAGE VENDOR STYLES ===========================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/jvectormap-next/jquery-jvectormap.css') }}">

    <!-- ======================= GLOBAL COMMON STYLES ============================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/common/main.bundle.css') }}">

    <!-- ======================= LAYOUT TYPE ===========================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/layouts/vertical/core/main.css') }}">

    <!-- ======================= MENU TYPE ===========================================-->
    <link rel="stylesheet" href="{{ asset('admin/assets/css/layouts/vertical/menu-type/default.css') }}">

    <!-- ======================= THEME COLOR STYLES ===========================-->
    {{-- <link rel="stylesheet" href="{{ asset('admin/assets/css/layouts/vertical/themes/theme-o.css') }}"> --}}

    {{-- Custom CSS --}}
    <link rel="stylesheet" href="{{ asset('admin/assets/css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/select2/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/assets/vendor/bootstrap-datepicker/bootstrap-datepicker.min.css') }}">

    <!-- Bootstrap Datepicker CSS -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">

    <!-- Bootstrap Datepicker JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <style>
        @php
            $backgroundColor = $settings->background_color ?? '#ffffff';
            $inputColor = $settings->input_color ?? '#5A080C';
            $buttonColor = $settings->button_color ?? '#5A080C';
            $textColor = $settings->text_color ?? '#5A080C';
            $iconColor = $settings->icon_color ?? '#5A080C';
        @endphp

        body {
            background-color: {{ $backgroundColor }};
        }

        input,
        textarea,
        select {
            background-color: {{ $inputColor }};
            border: 1px solid black;
        }

        .btn-primary {
            background-color: {{ $buttonColor }};
            border-color: {{ $buttonColor }};
        }

        .main-menu .nav li a {
            color: {{ $textColor }} !important;
        }

        .main-menu .nav li a i {
            color: {{ $iconColor }} !important;
        }

        :root {
            --input-color: {{ $inputColor }};
        }

        .form-control {
            border-color: var(--input-color);
        }

        .custom-file-label {
            border-color: var(--input-color);
        }
    </style>

    @stack('style')
</head>

<body>
