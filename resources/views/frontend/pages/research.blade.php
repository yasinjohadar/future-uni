@extends('frontend.layouts.master')

@section('title', 'البحث العلمي | جامعة المستقبل')
@section('body_class', 'research-page')
@section('active_nav', 'research')

@section('content')
    @include('frontend.pages.partials.research.hero')
    @include('frontend.pages.partials.research.research-highlights')
    @include('frontend.pages.partials.research.research')
    @include('frontend.pages.partials.research.research-pubs')
    @include('frontend.pages.partials.research.research-cta')
@endsection
