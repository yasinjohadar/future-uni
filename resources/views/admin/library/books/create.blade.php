@extends('admin.layouts.master')

@section('page-title') إضافة كتاب @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')
        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'كتب المكتبة', 'url' => route('admin.library.books.index')],
                ['label' => 'إضافة'],
            ],
            'title' => 'إضافة كتاب',
            'actions' => '<a href="' . route('admin.library.books.index') . '" class="btn btn-light border btn-wave"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
        ])

        <form action="{{ route('admin.library.books.store') }}" method="POST">
            @csrf
            <div class="row g-4">
                <div class="col-lg-8">@include('admin.library.books.partials.form-fields')</div>
                <div class="col-lg-4">@include('admin.library.books.partials.form-sidebar')</div>
            </div>
        </form>
    </div>
</div>
@endsection
