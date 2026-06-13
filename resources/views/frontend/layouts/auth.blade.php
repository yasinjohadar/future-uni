<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="dark">
<head>
    @php($fe = asset('frontend/assets'))
    @include('frontend.layouts.partials.theme-init')
    @include('frontend.layouts.partials.head')
</head>
<body @hasSection('body_class') class="@yield('body_class')" @endif>
    @yield('content')
    @include('frontend.layouts.partials.scripts')
</body>
</html>
