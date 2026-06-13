@extends('frontend.layouts.master')

@section('title', ($book->title ?? 'تفاصيل الكتاب') . ' | جامعة المستقبل')
@section('body_class', 'book-detail-page')
@section('active_nav', 'library')

@section('content')
    @include('frontend.pages.partials.book-detail.shell')
@endsection
