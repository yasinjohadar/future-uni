@extends('admin.layouts.master')

@section('page-title') تعديل قسم @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')
        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'الأقسام', 'url' => route('admin.academic.departments.index')],
                ['label' => $department->name],
            ],
            'title' => 'تعديل: ' . $department->name,
            'subtitle' => $department->college?->name ?? 'تحديث بيانات القسم',
            'actions' => '
                ' . ($department->college ? '<a href="' . route('departments.show', [$department->college->slug, $department->slug]) . '" class="btn btn-light border btn-wave btn-sm" target="_blank" rel="noopener"><i class="ri-external-link-line me-1"></i> معاينة</a>' : '') . '
                <a href="' . route('admin.academic.departments.index') . '" class="btn btn-light border btn-wave"><i class="ri-arrow-right-line me-1"></i> رجوع</a>
            ',
        ])

        <form action="{{ route('admin.academic.departments.update', $department) }}" method="POST" data-tinymce-form>
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-lg-8 order-lg-1">
                    @include('admin.academic.departments.partials.form-fields', [
                        'department' => $department,
                        'colleges' => $colleges,
                    ])
                </div>
                <div class="col-lg-4 order-lg-2">
                    @include('admin.academic.departments.partials.form-sidebar', [
                        'department' => $department,
                        'colleges' => $colleges,
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
