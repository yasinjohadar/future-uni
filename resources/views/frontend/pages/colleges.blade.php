@extends('frontend.layouts.master')

@section('title', 'الكليات | جامعة المستقبل')
@section('meta_description', 'اكتشف كليات جامعة المستقبل الأكاديمية المتنوعة وبرامجها المتميزة')
@section('body_class', 'colleges-page')
@section('active_nav', 'colleges')

@section('content')
    @include('frontend.pages.partials.shared.page-hero', [
        'heroIcon' => 'fas fa-building-columns',
        'heroTitle' => 'كليات الجامعة',
        'heroSubtitle' => 'اكتشف كلياتنا الأكاديمية المتنوعة وبرامجها المتميزة',
        'breadcrumbs' => [
            ['label' => 'الرئيسية', 'route' => 'home'],
            ['label' => 'الكليات'],
        ],
    ])
    @include('frontend.pages.partials.colleges.highlights')
    @include('frontend.pages.partials.colleges.grid')
    @include('frontend.pages.partials.colleges.cta')
@endsection
