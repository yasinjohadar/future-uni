@extends('admin.layouts.master')

@section('page-title')
    الصفحة الرئيسية
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">

        <div class="admin-toast-container" id="adminToastContainer"></div>
        @include('admin.partials.ui.alerts')

        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'الصفحة الرئيسية'],
            ],
            'title' => 'إدارة الصفحة الرئيسية',
            'subtitle' => 'شرائح العرض، الإحصائيات، والاعتمادات المعروضة في الواجهة',
        ])

        <div class="row g-3 mb-4">
            @include('admin.partials.ui.stat-card-gradient', [
                'variant' => 'cyan',
                'icon' => 'ri-slideshow-line',
                'label' => 'شرائح العرض',
                'value' => number_format($summary['hero_slides']),
                'hint' => $summary['hero_active'] . ' نشطة',
            ])
            @include('admin.partials.ui.stat-card-gradient', [
                'variant' => 'green',
                'icon' => 'ri-bar-chart-line',
                'label' => 'الإحصائيات',
                'value' => number_format($summary['stats']),
                'hint' => 'عناصر',
            ])
            @include('admin.partials.ui.stat-card-gradient', [
                'variant' => 'orange',
                'icon' => 'ri-award-line',
                'label' => 'الاعتمادات',
                'value' => number_format($summary['accreditations']),
                'hint' => 'شهادات',
            ])
        </div>

        @include('admin.homepage.partials.hero-slides')
        @include('admin.homepage.partials.stats')
        @include('admin.homepage.partials.accreditations')

        @include('admin.homepage.partials.modals')

    </div>
</div>
@endsection
