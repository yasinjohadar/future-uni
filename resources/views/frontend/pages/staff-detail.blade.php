@extends('frontend.layouts.master')

@section('title', ($member->name ?? 'تفاصيل العضو') . ' | جامعة المستقبل')
@section('body_class', 'staff-detail-page')

@section('content')
    @include('frontend.pages.partials.staff-detail.shell')
@endsection
