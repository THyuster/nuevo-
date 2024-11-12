<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link  rel="stylesheet" href="{{ asset('assets/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{ asset('assets/css/settings.css') }}">
    <link href="{{ asset('assets/css/responsive.dataTables.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body>
<div class="loader">
    <div class="loader-square"></div>
    <div class="loader-square"></div>
    <div class="loader-square"></div>
    <div class="loader-square"></div>
    <div class="loader-square"></div>
    <div class="loader-square"></div>
    <div class="loader-square"></div>
    </div>
</body>