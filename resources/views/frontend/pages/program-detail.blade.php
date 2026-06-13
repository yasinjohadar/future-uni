@extends('frontend.layouts.master')

@section('title', ($program->name ?? 'تفاصيل البرنامج') . ' | جامعة المستقبل')
@section('body_class', 'program-detail-page college-detail-page')
@section('active_nav', 'programs')

@section('content')
    @include('frontend.pages.partials.program-detail.shell')
@endsection
