@extends('frontend.layouts.master')

@section('title', 'التقويم الأكاديمي | جامعة المستقبل')
@section('body_class', 'calendar-page')

@section('content')
    @include('frontend.pages.partials.academic-calendar.hero')
    @include('frontend.pages.partials.academic-calendar.calendar-highlights')
    @include('frontend.pages.partials.academic-calendar.calendar')
    @include('frontend.pages.partials.academic-calendar.calendar-cta')
@endsection
