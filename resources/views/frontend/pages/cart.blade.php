@extends('frontend.layouts.master')

@section('title', 'بوابة الطلاب — جامعة المستقبل - السلة')
@section('body_class', 'cart-page')

@section('content')
@include('frontend.pages.partials.cart.hero')
    <main class="container py-4">
    @include('frontend.pages.partials.cart.content')
    </main>
@endsection

@push('vendor_scripts')
    <script src="{{ $fe }}/js/main.js"></script>
@endpush
