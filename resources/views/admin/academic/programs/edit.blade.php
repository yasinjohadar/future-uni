@extends('admin.layouts.master')

@section('page-title') تعديل برنامج @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')
        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'البرامج', 'url' => route('admin.academic.programs.index')],
                ['label' => $program->name],
            ],
            'title' => 'تعديل: ' . $program->name,
            'subtitle' => ($program->college?->name ?? '') . ($program->department ? ' · ' . $program->department->name : ''),
            'actions' => '
                <a href="' . route('programs.show', $program->slug) . '" class="btn btn-light border btn-wave btn-sm" target="_blank" rel="noopener"><i class="ri-external-link-line me-1"></i> معاينة</a>
                <a href="' . route('admin.academic.programs.index') . '" class="btn btn-light border btn-wave"><i class="ri-arrow-right-line me-1"></i> رجوع</a>
            ',
        ])

        <form action="{{ route('admin.academic.programs.update', $program) }}" method="POST" data-tinymce-form>
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-lg-8 order-lg-1">
                    @include('admin.academic.programs.partials.form-fields', [
                        'program' => $program,
                        'colleges' => $colleges,
                        'departments' => $departments,
                        'levels' => $levels,
                    ])
                </div>
                <div class="col-lg-4 order-lg-2">
                    @include('admin.academic.programs.partials.form-sidebar', [
                        'program' => $program,
                        'colleges' => $colleges,
                        'departments' => $departments,
                        'levels' => $levels,
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
