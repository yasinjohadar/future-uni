@extends('frontend.layouts.master')

@section('title', 'الأخبار والمقالات | جامعة المستقبل')
@section('body_class', 'blog-page')
@section('active_nav', 'news')

@section('content')
    @include('frontend.pages.partials.blog.hero')
    @include('frontend.pages.partials.blog.content')
@endsection
