@extends('frontend.layouts.master')

@section('title', 'بوابة الطلاب — جامعة المستقبل - الكورسات')
@section('body_class', 'courses-page')

@section('content')
@include('frontend.pages.partials.courses.hero')
    <main class="container py-4">
        <div class="row g-4">
    @include('frontend.pages.partials.courses.filters-sidebar')
    @include('frontend.pages.partials.courses.content-grid')
        </div>
    </main>
@endsection

@push('vendor_scripts')
    <script src="{{ $fe }}/js/main.js"></script>
@endpush
