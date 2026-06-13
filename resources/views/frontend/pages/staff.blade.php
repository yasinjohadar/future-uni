@extends('frontend.layouts.master')

@section('title', 'الهيئة الإدارية | جامعة المستقبل')
@section('body_class', 'staff-page')

@section('content')
    @include('frontend.pages.partials.staff.hero')
    @include('frontend.pages.partials.staff.staff-highlights')
    @include('frontend.pages.partials.staff.staff')
    @include('frontend.pages.partials.staff.staff-cta')
@endsection
