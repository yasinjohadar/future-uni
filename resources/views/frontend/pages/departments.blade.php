@extends('frontend.layouts.master')

@section('title', 'الأقسام الأكاديمية | جامعة المستقبل')
@section('body_class', 'departments-page')

@section('content')
    @include('frontend.pages.partials.departments.hero')
    @include('frontend.pages.partials.departments.departments-highlights')
    @include('frontend.pages.partials.departments.departments')
    @include('frontend.pages.partials.departments.departments-cta')
@endsection
