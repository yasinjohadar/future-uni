@extends('frontend.layouts.auth')

@section('title', 'بوابة الطلاب — ' . config('frontend.brand.name') . config('frontend.brand.accent'))
@section('body_class', 'auth-page auth-page--luxury')

@section('content')
    @include('frontend.pages.partials.login.form', [
        'useLaravelAuth' => true,
        'formAction' => route('login'),
        'formTitle' => 'بوابة الطلاب',
        'formSubtitle' => 'سجّل دخولك للوصول إلى المقررات والخدمات الطلابية',
        'brandingTitle' => 'مرحباً بعودتك!',
    ])
@endsection

@push('vendor_scripts')
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
@endpush

@include('frontend.pages.partials.login.scripts')
