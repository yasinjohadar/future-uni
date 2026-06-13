@extends('admin.layouts.master')

@section('page-title') إضافة كلية @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')
        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'الكليات', 'url' => route('admin.academic.colleges.index')],
                ['label' => 'إضافة'],
            ],
            'title' => 'إضافة كلية جديدة',
            'subtitle' => 'أدخل بيانات الكلية والمحتوى التعريفي',
            'actions' => '<a href="' . route('admin.academic.colleges.index') . '" class="btn btn-light border btn-wave"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
        ])

        <form action="{{ route('admin.academic.colleges.store') }}" method="POST" data-tinymce-form>
            @csrf

            <div class="row g-4">
                <div class="col-lg-8 order-lg-1">
                    @include('admin.academic.colleges.partials.form-fields')
                </div>
                <div class="col-lg-4 order-lg-2">
                    @include('admin.academic.colleges.partials.form-sidebar')
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
@include('admin.partials.tinymce-scripts', ['selectors' => ['#description', '#vision', '#mission']])
@include('admin.academic.colleges.partials.form-scripts')
@endpush
