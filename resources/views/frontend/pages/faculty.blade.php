@extends('frontend.layouts.master')

@section('title', 'هيئة التدريس | جامعة المستقبل')
@section('body_class', 'faculty-page')

@section('content')
    @include('frontend.pages.partials.faculty.hero')
    @include('frontend.pages.partials.faculty.faculty-highlights')
    @include('frontend.pages.partials.faculty.faculty')
    @include('frontend.pages.partials.faculty.faculty-cta')
@endsection
