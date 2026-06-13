@extends('admin.layouts.master')

@section('page-title') تعديل {{ $center->name }} @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')
        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'مراكز البحث', 'url' => route('admin.research.centers.index')],
                ['label' => $center->name],
            ],
            'title' => 'تعديل: ' . $center->name,
            'subtitle' => 'تحديث بيانات مركز البحث',
            'actions' => '<a href="' . route('admin.research.centers.show', $center) . '" class="btn btn-light border btn-sm"><i class="ri-eye-line"></i> عرض</a>',
        ])

        <form action="{{ route('admin.research.centers.update', $center) }}" method="POST" data-tinymce-form>
            @csrf
            @method('PUT')
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
