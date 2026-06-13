@extends('admin.layouts.master')

@section('page-title')
الكليات
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'الأكاديمي'],
                ['label' => 'الكليات'],
            ],
            'title' => 'الكليات',
            'subtitle' => 'إدارة كليات الجامعة',
            'actions' => '<a href="' . route('admin.academic.colleges.create') . '" class="btn btn-link text-primary fw-bold text-decoration-none p-0"><i class="ri-add-circle-line me-1 fs-18"></i> إضافة كلية</a>',
        ])

        <div class="row g-3 mb-4">
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-building-2-line', 'label' => 'إجمالي الكليات', 'value' => number_format($stats['total']), 'hint' => number_format($stats['filtered']) . ' حسب الفلاتر'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-checkbox-circle-line', 'label' => 'نشطة', 'value' => number_format($stats['active']), 'hint' => 'مفعّلة'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'cyan', 'icon' => 'ri-pause-circle-line', 'label' => 'غير نشطة', 'value' => number_format($stats['inactive']), 'hint' => 'معطّلة'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'orange', 'icon' => 'ri-organization-chart', 'label' => 'الأقسام', 'value' => number_format($stats['departments']), 'hint' => 'إجمالي الأقسام'])
        </div>

        <div class="filter-panel mb-4">
            <div class="filter-panel__title">تصفية الكليات</div>
            <div class="filter-panel__subtitle">ابحث بالاسم أو فلتر حسب حالة التفعيل</div>
            <form action="{{ route('admin.academic.colleges.index') }}" method="GET">
                <div class="row g-2 g-md-3 align-items-end">
                    <div class="col-lg-5">
                        <label class="form-label fs-12 text-muted mb-1">بحث</label>
                        <div class="search-input-wrap">
                            <i class="ri-search-line"></i>
                            <input type="text" name="search" class="form-control"
                                   placeholder="البحث بالاسم أو التصنيف..."
                                   value="{{ request('search') }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label fs-12 text-muted mb-1">الحالة</label>
                        <select name="status" class="form-select">
                            <option value="">كل الحالات</option>
                            <option value="active" @selected(request('status') === 'active')>نشطة</option>
                            <option value="inactive" @selected(request('status') === 'inactive')>غير نشطة</option>
                        </select>
                    </div>
                    <div class="col-lg-4 d-flex gap-2">
                        <button type="submit" class="btn btn-primary flex-fill">
                            <i class="ri-search-2-line me-1"></i> بحث
                        </button>
                        <a href="{{ route('admin.academic.colleges.index') }}" class="btn btn-light border" title="مسح الفلاتر">
                            <i class="ri-refresh-line"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <div class="card custom-card data-table-card">
            <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div class="d-flex align-items-center gap-2">
                    <span class="fw-bold fs-16">قائمة الكليات</span>
                    <span class="table-count-badge">{{ number_format($stats['filtered']) }}</span>
                </div>
            </div>

            @include('admin.academic.colleges.partials.list')
        </div>

        <div id="collegesModalsHost">
            @include('admin.academic.colleges.partials.modals')
        </div>
    </div>
</div>
@endsection
