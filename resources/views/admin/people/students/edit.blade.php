@extends('admin.layouts.master')

@section('page-title', 'تعديل طالب')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'الطلاب', 'url' => route('admin.people.students.index')],
                ['label' => $student->user?->name ?? $student->student_number],
            ],
            'title' => 'تعديل: ' . ($student->user?->name ?? $student->student_number),
            'subtitle' => $student->student_number . ($student->program ? ' · ' . $student->program->name : ''),
            'actions' => '<a href="' . route('admin.people.students.index') . '" class="btn btn-light border btn-wave"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
        ])

        <form method="POST" action="{{ route('admin.people.students.update', $student) }}">
            @csrf
            @method('PUT')

            <div class="row g-4">
                <div class="col-lg-8 order-lg-1">
                    @include('admin.people.students.partials.form-fields', [
                        'student' => $student,
                        'programs' => $programs,
                    ])
                </div>
                <div class="col-lg-4 order-lg-2">
                    @include('admin.people.students.partials.form-sidebar', [
                        'student' => $student,
                        'programs' => $programs,
                    ])
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
@include('admin.people.students.partials.form-scripts')
@endpush
