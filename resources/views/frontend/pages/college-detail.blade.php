@extends('frontend.layouts.master')

@section('title', ($college->name ?? 'تفاصيل الكلية') . ' | جامعة المستقبل')
@section('body_class', 'college-detail-page')
@section('active_nav', 'colleges')

@section('content')
    @include('frontend.pages.partials.college-detail.shell')
@endsection
