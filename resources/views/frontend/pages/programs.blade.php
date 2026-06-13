@extends('frontend.layouts.master')

@section('title', 'البرامج الأكاديمية | جامعة المستقبل')
@section('body_class', 'programs-page')

@section('content')
    @include('frontend.pages.partials.programs.hero')
    @include('frontend.pages.partials.programs.programs-highlights')
    @include('frontend.pages.partials.programs.programs')
    @include('frontend.pages.partials.programs.programs-cta')
@endsection
