@extends('frontend.layouts.master')

@section('title', 'سياسة الخصوصية | جامعة المستقبل')
@section('body_class', 'privacy-page')

@section('content')
    @include('frontend.pages.partials.privacy.hero')
    @include('frontend.pages.partials.privacy.legal-highlights')
    @include('frontend.pages.partials.privacy.legal')
    @include('frontend.pages.partials.privacy.legal-cta')
@endsection
