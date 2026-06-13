@extends('frontend.layouts.master')

@section('title', 'بوابة الطلاب — جامعة المستقبل - الدفع')
@section('body_class', 'checkout-page')

@section('content')
@include('frontend.pages.partials.checkout.hero')
    <main class="container py-4">
    @include('frontend.pages.partials.checkout.content')
    </main>
@endsection

@push('vendor_scripts')
    <script src="{{ $fe }}/js/main.js"></script>
@endpush
