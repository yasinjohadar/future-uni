@extends('admin.layouts.master')

@section('page-title') إضافة مركز بحث @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')
        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'مراكز البحث', 'url' => route('admin.research.centers.index')],
                ['label' => 'إضافة'],
            ],
            'title' => 'إضافة مركز بحث',
            'subtitle' => 'أدخل بيانات المركز والمحتوى التفصيلي',
            'actions' => '<a href="' . route('admin.research.centers.index') . '" class="btn btn-light border btn-wave"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
        ])

        <form action="{{ route('admin.research.centers.store') }}" method="POST" data-tinymce-form>
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">@include('admin.research.centers.partials.form-fields')</div>
                <div class="col-lg-4">@include('admin.research.centers.partials.form-sidebar')</div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
@include('admin.partials.tinymce-scripts', ['selectors' => ['#long_description']])
@endpush
