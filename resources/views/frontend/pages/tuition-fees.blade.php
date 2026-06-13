@extends('frontend.layouts.master')

@section('title', 'الرسوم الدراسية | جامعة المستقبل')
@section('body_class', 'tuition-page')

@section('content')
    @include('frontend.pages.partials.tuition-fees.hero')
    @include('frontend.pages.partials.tuition-fees.tuition-highlights')
    @include('frontend.pages.partials.tuition-fees.tuition')
    @include('frontend.pages.partials.tuition-fees.tuition-cta')
@endsection
