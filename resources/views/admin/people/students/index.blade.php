@extends('admin.layouts.master')

@section('page-title', 'الطلاب')

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        <div class="admin-toast-container" id="adminToastContainer"></div>
        @include('admin.partials.ui.alerts')

        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'الطلاب'],
            ],
            'title' => 'إدارة الطلاب',
            'subtitle' => 'SIS Lite — سجل الطلاب والبرامج',
            'actions' => '<a href="' . route('admin.people.students.create') . '" class="btn btn-link text-primary fw-bold text-decoration-none p-0"><i class="ri-user-add-line me-1 fs-18"></i> إضافة طالب</a>',
        ])

        <div class="row g-3 mb-4">
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-graduation-cap-line', 'label' => 'إجمالي الطلاب', 'value' => number_format($stats['total']), 'hint' => number_format($stats['filtered']) . ' حسب الفلاتر'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-checkbox-circle-line', 'label' => 'نشطون', 'value' => number_format($stats['active']), 'hint' => 'طلاب مسجلون'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'cyan', 'icon' => 'ri-award-line', 'label' => 'متخرجون', 'value' => number_format($stats['graduated']), 'hint' => 'أكملوا الدراسة'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'orange', 'icon' => 'ri-pause-circle-line', 'label' => 'موقوفون', 'value' => number_format($stats['suspended']), 'hint' => 'حالة suspended'])
        </div>

        <div class="filter-panel mb-4">
            <div class="filter-panel__title">تصفية الطلاب</div>
            <div class="filter-panel__subtitle">ابحث برقم الطالب أو الاسم أو فلتر حسب البرنامج والحالة</div>
            <x-admin.ajax-filter-form
                :action="route('admin.people.students.index')"
                target="#studentsAjaxTarget"
                modals-target="#studentsModalsHost"
                count-target="#studentsFilteredCount"
                :reset-url="route('admin.people.students.index')"
                id="studentsFilterForm">
                <div class="row g-2 g-md-3 align-items-end">
                    <div class="col-lg-4">
                        <label class="form-label fs-12 text-muted mb-1">بحث</label>
                        <div class="search-input-wrap">
                            <i class="ri-search-line"></i>
                            <input type="text" name="search" class="form-control" data-ajax-search
                                   placeholder="بحث برقم الطالب أو الاسم..."
                                   value="{{ request('search') }}" autocomplete="off">
                        </div>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label fs-12 text-muted mb-1">البرنامج</label>
                        <select name="program_id" class="form-select" data-ajax-auto>
                            <option value="">كل البرامج</option>
                            @foreach($programs as $program)
                                <option value="{{ $program->id }}" @selected(request('program_id') == $program->id)>{{ $program->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-3">
                        <label class="form-label fs-12 text-muted mb-1">الحالة</label>
                        <select name="status" class="form-select" data-ajax-auto>
                            <option value="">كل الحالات</option>
                            <option value="active" @selected(request('status') === 'active')>نشط</option>
                            <option value="inactive" @selected(request('status') === 'inactive')>غير نشط</option>
                            <option value="graduated" @selected(request('status') === 'graduated')>متخرج</option>
                            <option value="suspended" @selected(request('status') === 'suspended')>موقوف</option>
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
                    <span class="fw-bold fs-16">قائمة الطلاب</span>
                    <span class="table-count-badge" id="studentsFilteredCount">{{ number_format($stats['filtered']) }}</span>
                </div>
            </div>
            <div class="ajax-filter-target" id="studentsAjaxTarget">
                @include('admin.people.students.partials.list')
            </div>
        </div>

        <div id="studentsModalsHost">
            @include('admin.people.students.partials.modals')
        </div>
    </div>
</div>
@endsection
