@extends('frontend.layouts.master')

@section('title', $center->name . ' | جامعة المستقبل')
@section('body_class', 'research-detail-page')
@section('active_nav', 'research')

@section('content')
    @include('frontend.pages.partials.research-detail.shell')
@endsection
