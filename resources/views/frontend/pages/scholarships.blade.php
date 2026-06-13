@extends('frontend.layouts.master')

@section('title', 'المنح الدراسية | جامعة المستقبل')
@section('body_class', 'scholarships-page')

@section('content')
    @include('frontend.pages.partials.scholarships.hero')
    @include('frontend.pages.partials.scholarships.scholarships-highlights')
    @include('frontend.pages.partials.scholarships.scholarships')
    @include('frontend.pages.partials.scholarships.scholarships-cta')
@endsection
