@extends('admin.layouts.master')

@section('page-title') إضافة برنامج @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')
        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'البرامج', 'url' => route('admin.academic.programs.index')],
                ['label' => 'إضافة'],
            ],
            'title' => 'إضافة برنامج أكاديمي',
            'subtitle' => 'أدخل بيانات البرنامج والمحتوى التعريفي',
            'actions' => '<a href="' . route('admin.academic.programs.index') . '" class="btn btn-light border btn-wave"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
        ])

        <form action="{{ route('admin.academic.programs.store') }}" method="POST" data-tinymce-form>
            @csrf

            <div class="row g-4">
                <div class="col-lg-8 order-lg-1">
                    @include('admin.academic.programs.partials.form-fields', [
                        'colleges' => $colleges,
                        'departments' => $departments,
                        'levels' => $levels,
                        'selectedCollegeId' => $selectedCollegeId,
                        'selectedDepartmentId' => $selectedDepartmentId,
                    ])
                </div>
                <div class="col-lg-4 order-lg-2">
                    @include('admin.academic.programs.partials.form-sidebar', [
                        'colleges' => $colleges,
                        'departments' => $departments,
                        'levels' => $levels,
                        'selectedCollegeId' => $selectedCollegeId,
                        'selectedDepartmentId' => $selectedDepartmentId,
                    ])
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
@include('admin.partials.tinymce-scripts', ['selectors' => ['#description', '#requirements']])
@include('admin.academic.programs.partials.form-scripts')
@endpush
