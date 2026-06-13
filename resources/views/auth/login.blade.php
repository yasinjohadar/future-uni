@extends('frontend.layouts.auth')

@section('title', 'تسجيل الدخول | ' . config('frontend.brand.name') . config('frontend.brand.accent'))
@section('meta_description', 'تسجيل الدخول إلى منصة جامعة المستقبل — لوحة التحكم والخدمات الأكاديمية')
@section('body_class', 'auth-page auth-page--luxury')

@section('content')
    @include('frontend.pages.partials.login.form', [
        'useLaravelAuth' => true,
        'formAction' => route('login'),
        'formTitle' => 'تسجيل الدخول',
        'formSubtitle' => 'أدخل بياناتك للوصول إلى لوحة التحكم والخدمات الإدارية',
        'brandingTitle' => 'نحو مستقبل أكاديمي متميز',
        'showDemoAdminFill' => true,
    ])
@endsection

@push('vendor_scripts')
    <script src="{{ asset('frontend/assets/js/main.js') }}"></script>
@endpush

@include('frontend.pages.partials.login.scripts')
