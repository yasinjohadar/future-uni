@extends('frontend.layouts.master')

@section('title', 'المكتبة الجامعية | جامعة المستقبل')
@section('body_class', 'library-page')
@section('active_nav', 'library')

@section('content')
    @include('frontend.pages.partials.library.hero')
    @include('frontend.pages.partials.library.library-highlights')
    @include('frontend.pages.partials.library.library-toolbar')
    @include('frontend.pages.partials.library.library')
    @include('frontend.pages.partials.library.library-cta')
@endsection
