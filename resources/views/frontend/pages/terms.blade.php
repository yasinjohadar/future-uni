@extends('frontend.layouts.master')

@section('title', 'الشروط والأحكام | جامعة المستقبل')
@section('body_class', 'terms-page')

@section('content')
    @include('frontend.pages.partials.terms.hero')
    @include('frontend.pages.partials.terms.legal-highlights')
    @include('frontend.pages.partials.terms.legal')
    @include('frontend.pages.partials.terms.legal-cta')
@endsection
