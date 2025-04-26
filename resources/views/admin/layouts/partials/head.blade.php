<!doctype html>
<html lang="en" data-bs-theme="semi-dark">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>{{ config('app.name') }} | @yield('title', 'Default Title')</title>
    <link href="{{ asset('assets/admin/css/pace.min.css') }}" rel="stylesheet">
    <script src="{{ asset('assets/admin/js/pace.min.js') }}"></script>

    <!--plugins-->
    <link href="{{ asset('assets/admin/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/plugins/metismenu/metisMenu.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/plugins/metismenu/mm-vertical.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/admin/plugins/simplebar/css/simplebar.css') }}">
    <!--bootstrap css-->
    <link href="{{ asset('assets/admin/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Material+Icons+Outlined" rel="stylesheet">
    <!--main css-->
    <link href="{{ asset('assets/admin/css/bootstrap-extended.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/sass/main.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/sass/dark-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/sass/blue-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/sass/semi-dark.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/sass/bordered-theme.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/admin/sass/responsive.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/admin/plugins/IconPicker/dist/iconpicker-1.5.0.css') }}" />
    <link href="{{ asset('assets/admin/css/custom.css') }}" rel="stylesheet">
    <link rel="shortcut icon" href="{{ asset('assets/principal/img/logo/logo.png') }}" />
    @livewireStyles
    @stack('styles')
</head>
