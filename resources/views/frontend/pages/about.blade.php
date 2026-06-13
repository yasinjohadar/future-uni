@extends('frontend.layouts.master')

@section('title', 'عن الجامعة | جامعة المستقبل')
@section('meta_description', 'تعرف على تاريخ جامعة المستقبل ورؤيتها ورسالتها وقيمها الأكاديمية')
@section('body_class', 'about-page')
@section('active_nav', 'about')

@section('content')
    @include('frontend.pages.partials.shared.page-hero', [
        'heroIcon' => 'fas fa-university',
        'heroTitle' => 'عن جامعة المستقبل',
        'heroSubtitle' => 'تعرف على تاريخنا ورؤيتنا وقيمنا التي نؤمن بها',
        'breadcrumbs' => [
            ['label' => 'الرئيسية', 'route' => 'home'],
            ['label' => 'عن الجامعة'],
        ],
    ])
    @include('frontend.pages.partials.about.highlights')
    @include('frontend.pages.partials.about.intro')
    @include('frontend.pages.partials.about.vision-mission')
    @include('frontend.pages.partials.about.values')
    @include('frontend.pages.partials.about.president-message')
    @include('frontend.pages.partials.about.timeline')
    @include('frontend.pages.partials.about.cta')
@endsection
