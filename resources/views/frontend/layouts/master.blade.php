<!DOCTYPE html>
<html lang="ar" dir="rtl" data-theme="dark">
<head>
    @php($fe = asset('frontend/assets'))
    @include('frontend.layouts.partials.theme-init')
    @include('frontend.layouts.partials.head')
</head>
<body @hasSection('body_class') class="@yield('body_class')" @endif>
    @include('frontend.layouts.partials.top-bar')
    @include('frontend.layouts.partials.navbar')

    <div id="toast-container"></div>

    <main>
        @yield('content')
    </main>

    @include('frontend.layouts.partials.footer')
    @include('frontend.layouts.partials.back-to-top')
    @include('frontend.layouts.partials.scripts')
</body>
</html>
