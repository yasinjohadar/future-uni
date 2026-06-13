@extends('frontend.layouts.master')

@section('title', 'بوابة الطلاب — جامعة المستقبل - تفاصيل الكورس')
@section('body_class', 'course-detail-page')

@section('content')
    @include('frontend.pages.partials.course-detail.content')
@endsection

@push('vendor_scripts')
    <script src="{{ $fe }}/js/main.js"></script>
@endpush
