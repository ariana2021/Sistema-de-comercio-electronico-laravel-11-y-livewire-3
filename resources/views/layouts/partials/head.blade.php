<!doctype html>
<html class="no-js" lang="zxx">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Place favicon.ico in the root directory -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/principal/img/logo/logo.png') }}">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('assets/principal/css/bootstrap.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/principal/css/swiper-bundle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/principal/css/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/principal/css/magnific-popup.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/principal/css/font-awesome-pro.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/principal/css/flaticon_shofy.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/principal/css/spacing.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/principal/css/main.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/principal/css/custom.css') }}">
    @stack('styles')
</head>
