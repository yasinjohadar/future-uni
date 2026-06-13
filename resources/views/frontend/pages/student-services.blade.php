@extends('frontend.layouts.master')

@section('title', 'خدمات الطلاب | جامعة المستقبل')
@section('body_class', 'student-services-page')

@section('content')
    @include('frontend.pages.partials.student-services.hero')
    @include('frontend.pages.partials.student-services.services-highlights')
    @include('frontend.pages.partials.student-services.services')
    @include('frontend.pages.partials.student-services.services-cta')
@endsection
