@extends('frontend.layouts.master')

@section('title', ($department->name ?? 'تفاصيل القسم') . ' | جامعة المستقبل')
@section('body_class', 'department-detail-page college-detail-page')
@section('active_nav', 'colleges')

@section('content')
    @include('frontend.pages.partials.department-detail.shell')
@endsection
