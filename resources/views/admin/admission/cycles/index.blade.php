@extends('admin.layouts.master')
@section('page-title') دورات القبول @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'دورات القبول']],
    'title' => 'دورات القبول',
    'subtitle' => 'إدارة فترات التقديم والقبول',
    'actions' => '<a href="' . route('admin.admission.cycles.create') . '" class="btn btn-link text-primary fw-bold text-decoration-none p-0"><i class="ri-add-circle-line me-1"></i> إضافة دورة</a>',
])
<div class="row g-3 mb-4">
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-calendar-line', 'label' => 'الدورات', 'value' => number_format($stats['total']), 'hint' => number_format($stats['filtered']) . ' حسب الفلاتر'])
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-door-open-line', 'label' => 'مفتوحة', 'value' => number_format($stats['open']), 'hint' => 'قبول مفتوح'])
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'orange', 'icon' => 'ri-file-list-line', 'label' => 'الطلبات', 'value' => number_format($stats['applications']), 'hint' => 'إجمالي الطلبات'])
</div>
<div class="filter-panel mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-5"><input type="text" name="search" class="form-control" placeholder="بحث بالاسم أو السنة..." value="{{ request('search') }}"></div>
        <div class="col-md-3">
            <select name="status" class="form-select">
                <option value="">كل الحالات</option>
                <option value="open" @selected(request('status') === 'open')>مفتوحة</option>
                <option value="closed" @selected(request('status') === 'closed')>مغلقة</option>
            </select>
        </div>
        <div class="col-md-4 d-flex gap-2"><button class="btn btn-primary">بحث</button><a href="{{ route('admin.admission.cycles.index') }}" class="btn btn-light border">مسح</a></div>
    </form>
</div>
<div class="card custom-card"><div class="card-body p-0">
<table class="table data-table mb-0">
<thead><tr><th>#</th><th>الاسم</th><th>السنة الأكاديمية</th><th>الفترة</th><th>الطلبات</th><th>الحالة</th><th>إجراءات</th></tr></thead>
<tbody>
@forelse($cycles as $cycle)
<tr>
    <td>{{ $cycles->firstItem() + $loop->index }}</td>
    <td><a href="{{ route('admin.admission.cycles.edit', $cycle) }}" class="fw-bold text-decoration-none">{{ $cycle->name }}</a></td>
    <td>{{ $cycle->academic_year }}</td>
    <td>{{ $cycle->start_date?->format('Y-m-d') ?: '—' }} — {{ $cycle->end_date?->format('Y-m-d') ?: '—' }}</td>
    <td><a href="{{ route('admin.admission.applications.index', ['cycle_id' => $cycle->id]) }}">{{ $cycle->applications_count }}</a></td>
    <td>{{ $cycle->is_open ? 'مفتوحة' : 'مغلقة' }}</td>
    <td>
        <a href="{{ route('admin.admission.cycles.show', $cycle) }}" class="btn btn-sm btn-light"><i class="ri-eye-line"></i></a>
        <a href="{{ route('admin.admission.cycles.edit', $cycle) }}" class="btn btn-sm btn-light"><i class="ri-pencil-line"></i></a>
        <form action="{{ route('admin.admission.cycles.toggle-active', $cycle) }}" method="POST" class="d-inline">@csrf<button class="btn btn-sm btn-light"><i class="ri-toggle-line"></i></button></form>
        <form action="{{ route('admin.admission.cycles.destroy', $cycle) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف الدورة؟')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i></button></form>
    </td>
</tr>
@empty
<tr><td colspan="7" class="text-center py-4 text-muted">لا توجد دورات</td></tr>
@endforelse
</tbody></table>
@if($cycles->hasPages())<div class="card-footer">{{ $cycles->links() }}</div>@endif
</div></div>
</div></div>
@endsection
