@extends('frontend.layouts.master')

@section('title', 'القبول والتسجيل | جامعة المستقبل')
@section('body_class', 'admission-page')
@section('active_nav', 'admission')

@section('content')
    @include('frontend.pages.partials.admission.hero')
    @include('frontend.pages.partials.admission.admission-highlights')
    @include('frontend.pages.partials.admission.admission-quicklinks')
    @include('frontend.pages.partials.admission.admission')
    @include('frontend.pages.partials.admission.admission-steps')
    @include('frontend.pages.partials.admission.admission-form')
    @include('frontend.pages.partials.admission.admission-cta')
@endsection
