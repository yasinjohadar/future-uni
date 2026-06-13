@extends('admin.layouts.master')

@section('page-title')
الأقسام
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="admin-toast-container" id="adminToastContainer"></div>
        @include('admin.partials.ui.alerts')

        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'الأكاديمي'],
                ['label' => 'الأقسام'],
            ],
            'title' => 'الأقسام',
            'subtitle' => 'إدارة أقسام الكليات',
            'actions' => '<a href="' . route('admin.academic.departments.create', request()->only('college_id')) . '" class="btn btn-link text-primary fw-bold text-decoration-none p-0"><i class="ri-add-circle-line me-1 fs-18"></i> إضافة قسم</a>',
        ])

        <div class="row g-3 mb-4">
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-node-tree', 'label' => 'إجمالي الأقسام', 'value' => number_format($stats['total']), 'hint' => number_format($stats['filtered']) . ' حسب الفلاتر'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-checkbox-circle-line', 'label' => 'نشطة', 'value' => number_format($stats['active']), 'hint' => 'مفعّلة'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'cyan', 'icon' => 'ri-pause-circle-line', 'label' => 'غير نشطة', 'value' => number_format($stats['inactive']), 'hint' => 'معطّلة'])
        </div>

        <div class="filter-panel mb-4">
            <div class="filter-panel__title">تصفية الأقسام</div>
            <div class="filter-panel__subtitle">ابحث بالاسم أو فلتر حسب الكلية وحالة التفعيل</div>
            <x-admin.ajax-filter-form
                :action="route('admin.academic.departments.index')"
                target="#departmentsAjaxTarget"
                modals-target="#departmentsModalsHost"
                count-target="#departmentsFilteredCount"
                :reset-url="route('admin.academic.departments.index')"
                id="departmentsFilterForm">
                <div class="row g-2 g-md-3 align-items-end">
                    <div class="col-lg-4">
                        <label class="form-label fs-12 text-muted mb-1">بحث</label>
                        <div class="search-input-wrap">
                            <i class="ri-search-line"></i>
                            <input type="text" name="search" class="form-control" data-ajax-search
                                   placeholder="البحث باسم القسم..."
                                   value="{{ request('search') }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label fs-12 text-muted mb-1">الكلية</label>
                        <select name="college_id" class="form-select" data-ajax-auto>
                            <option value="">كل الكليات</option>
                            @foreach($colleges as $college)
                                <option value="{{ $college->id }}" @selected(request('college_id') == $college->id)>{{ $college->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label fs-12 text-muted mb-1">الحالة</label>
                        <select name="status" class="form-select" data-ajax-auto>
                            <option value="">كل الحالات</option>
                            <option value="active" @selected(request('status') === 'active')>نشطة</option>
                            <option value="inactive" @selected(request('status') === 'inactive')>غير نشطة</option>
                        </select>
                    </div>
                    <div class="col-lg-2 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="ri-search-2-line me-1"></i> بحث
                        </button>
                        <button type="button" class="btn btn-light border" data-ajax-reset title="مسح الفلاتر">
                            <i class="ri-refresh-line"></i>
                        </button>
                    </div>
                </div>
            </x-admin.ajax-filter-form>
        </div>

        <div class="card custom-card data-table-card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold fs-16">قائمة الأقسام</span>
                    <span class="table-count-badge" id="departmentsFilteredCount">{{ number_format($stats['filtered']) }}</span>
                </div>
            </div>
            <div class="ajax-filter-target" id="departmentsAjaxTarget">
                @include('admin.academic.departments.partials.list')
            </div>
        </div>

        <div id="departmentsModalsHost">
            @include('admin.academic.departments.partials.modals')
        </div>
    </div>
</div>
@endsection
