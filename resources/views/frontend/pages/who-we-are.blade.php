@extends('frontend.layouts.master')

@section('title', 'بوابة الطلاب — جامعة المستقبل - من نحن')
@section('body_class', 'who-we-are-page')

@section('content')
@include('frontend.pages.partials.who-we-are.hero')
    <main class="container py-5">
    @include('frontend.pages.partials.who-we-are.content')
    </main>
@endsection
