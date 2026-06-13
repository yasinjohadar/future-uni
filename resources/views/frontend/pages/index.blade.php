@extends('frontend.layouts.master')

@section('title', 'جامعة المستقبل | الصفحة الرئيسية')
@section('active_nav', 'home')

@push('styles')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css">
@endpush

@section('content')
    @include('frontend.pages.partials.home.hero-carousel')
    @include('frontend.pages.partials.home.stats')
    @include('frontend.pages.partials.home.about')
    @include('frontend.pages.partials.home.colleges')
    @include('frontend.pages.partials.home.why-choose-us')
    @include('frontend.pages.partials.home.accreditations')
    @include('frontend.pages.partials.home.programs')
    @include('frontend.pages.partials.home.staff-slider')
    @include('frontend.pages.partials.home.news')
    @include('frontend.pages.partials.home.cta')
@endsection

@push('vendor_scripts')
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
@endpush

@push('scripts')
    <script>
        const staffSwiper = new Swiper('.staff-swiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            autoplay: { delay: 4000, disableOnInteraction: false },
            pagination: { el: '.staff-pagination', clickable: true },
            navigation: { nextEl: '.staff-next', prevEl: '.staff-prev' },
            breakpoints: {
                576:  { slidesPerView: 2 },
                992:  { slidesPerView: 3 },
                1200: { slidesPerView: 4 }
            }
        });

        const newsSwiper = new Swiper('.news-swiper', {
            slidesPerView: 1,
            spaceBetween: 24,
            loop: true,
            autoplay: { delay: 5000, disableOnInteraction: false },
            pagination: { el: '.news-pagination', clickable: true },
            navigation: { nextEl: '.news-next', prevEl: '.news-prev' },
            breakpoints: {
                768: { slidesPerView: 2 },
                1024: { slidesPerView: 3 }
            }
        });
    </script>
@endpush
