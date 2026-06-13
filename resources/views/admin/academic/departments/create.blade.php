@extends('admin.layouts.master')

@section('page-title') إضافة قسم @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')
        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'الأقسام', 'url' => route('admin.academic.departments.index')],
                ['label' => 'إضافة'],
            ],
            'title' => 'إضافة قسم جديد',
            'subtitle' => 'أدخل بيانات القسم والوصف التعريفي',
            'actions' => '<a href="' . route('admin.academic.departments.index') . '" class="btn btn-light border btn-wave"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
        ])

        <form action="{{ route('admin.academic.departments.store') }}" method="POST" data-tinymce-form>
            @csrf

            <div class="row g-4">
                <div class="col-lg-8 order-lg-1">
                    @include('admin.academic.departments.partials.form-fields', [
                        'colleges' => $colleges,
                        'selectedCollegeId' => $selectedCollegeId,
                    ])
                </div>
                <div class="col-lg-4 order-lg-2">
                    @include('admin.academic.departments.partials.form-sidebar', [
                        'colleges' => $colleges,
                        'selectedCollegeId' => $selectedCollegeId,
                    ])
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
@include('admin.partials.tinymce-scripts', ['selectors' => ['#description']])
@include('admin.academic.departments.partials.form-scripts')
@endpush
