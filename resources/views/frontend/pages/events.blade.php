@extends('frontend.layouts.master')

@section('title', 'الفعاليات | جامعة المستقبل')
@section('body_class', 'events-page')

@section('content')
    @include('frontend.pages.partials.events.hero')
    @include('frontend.pages.partials.events.events-highlights')
    @include('frontend.pages.partials.events.events')
    @include('frontend.pages.partials.events.events-cta')
@endsection
