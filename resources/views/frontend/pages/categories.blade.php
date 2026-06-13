@extends('frontend.layouts.master')

@section('title', 'بوابة الطلاب — جامعة المستقبل - التصنيفات')
@section('body_class', 'categories-page')

@section('content')
@include('frontend.pages.partials.categories.hero')
    <main class="container py-4">
    @include('frontend.pages.partials.categories.content')
    </main>
@endsection

@push('vendor_scripts')
    <script src="{{ $fe }}/js/main.js"></script>
@endpush
