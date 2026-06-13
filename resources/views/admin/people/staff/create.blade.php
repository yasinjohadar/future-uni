@extends('admin.layouts.master')

@section('page-title') إضافة عضو @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'أعضاء الهيئة', 'url' => route('admin.people.staff.index')],
                ['label' => 'إضافة'],
            ],
            'title' => 'إضافة عضو هيئة',
            'subtitle' => 'إنشاء ملف عضو أكاديمي أو إداري',
            'actions' => '<a href="' . route('admin.people.staff.index') . '" class="btn btn-light border btn-wave"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
        ])

        <form action="{{ route('admin.people.staff.store') }}" method="POST" data-tinymce-form>
            @csrf

            <div class="row g-4">
                <div class="col-lg-8 order-lg-1">
                    @include('admin.people.staff.partials.form-fields', [
                        'colleges' => $colleges,
                        'departments' => $departments,
                        'programs' => $programs,
                        'types' => $types,
                    ])
                </div>
                <div class="col-lg-4 order-lg-2">
                    @include('admin.people.staff.partials.form-sidebar', ['types' => $types])
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
@include('admin.partials.tinymce-scripts', ['selectors' => ['#bio']])
@include('admin.people.staff.partials.form-scripts')
@endpush
