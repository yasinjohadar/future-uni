<!DOCTYPE html>
<html lang="ar" dir="rtl" data-nav-layout="vertical" data-theme-mode="light" data-header-styles="light"
    data-menu-styles="light" data-toggled="close">

<head>
    @include('doctor.layouts.theme-init')

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('page-title') — بوابة الدكتور</title>

    @include('doctor.layouts.head')

    @yield('css')
    @yield('styles')
    @stack('styles')
</head>

<body class="admin-ui doctor-ui">

    @include('doctor.layouts.switcher')

    <div id="loader">
        <img src="{{ asset('assets/images/media/loader.svg') }}" alt="">
    </div>

    <div class="page">
        @include('doctor.layouts.main-header')
        @include('doctor.layouts.offcanvas-sidebar')
        @include('doctor.layouts.main-sidebar')

        @yield('content')

        @include('doctor.layouts.footer')
    </div>

    @include('doctor.layouts.footer-scripts')
</body>

</html>
