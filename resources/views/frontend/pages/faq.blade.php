@extends('frontend.layouts.master')

@section('title', 'الأسئلة الشائعة | جامعة المستقبل')
@section('body_class', 'faq-page')

@section('content')
    @include('frontend.pages.partials.faq.hero')
    @include('frontend.pages.partials.faq.faq-highlights')
    @include('frontend.pages.partials.faq.faq')
    @include('frontend.pages.partials.faq.faq-cta')
@endsection
