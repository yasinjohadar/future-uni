@extends('frontend.layouts.master')

@section('title', 'تواصل معنا | جامعة المستقبل')
@section('body_class', 'contact-page')
@section('active_nav', 'contact')

@section('content')
    @include('frontend.pages.partials.contact.hero')
    @include('frontend.pages.partials.contact.contact-highlights')
    @include('frontend.pages.partials.contact.contact')
@endsection
