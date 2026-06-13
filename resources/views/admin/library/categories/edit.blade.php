@extends('admin.layouts.master')

@section('page-title') تعديل تصنيف @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')
        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'تصنيفات المكتبة', 'url' => route('admin.library.categories.index')],
                ['label' => 'تعديل'],
            ],
            'title' => 'تعديل: ' . $category->name,
            'actions' => '<a href="' . route('admin.library.categories.index') . '" class="btn btn-light border btn-wave"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
        ])

        <form action="{{ route('admin.library.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row g-4">
                <div class="col-lg-8">@include('admin.library.categories.partials.form-fields')</div>
                <div class="col-lg-4">@include('admin.library.categories.partials.form-sidebar')</div>
            </div>
        </form>
    </div>
</div>
@endsection
