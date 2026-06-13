@extends('frontend.layouts.master')

@section('title', 'الأخبار والفعاليات | جامعة المستقبل')
@section('body_class', 'news-page')
@section('active_nav', 'news')

@section('content')
    @include('frontend.pages.partials.news.hero')
    @include('frontend.pages.partials.news.news-highlights')
    @include('frontend.pages.partials.news.news')
    @include('frontend.pages.partials.news.news-events')
@endsection
