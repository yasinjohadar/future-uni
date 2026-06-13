@extends('admin.layouts.master')
@section('page-title') طلبات القبول @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'طلبات القبول']],
    'title' => 'طلبات القبول',
    'subtitle' => 'مراجعة وإدارة طلبات التقديم',
    'actions' => '<a href="' . route('admin.admission.applications.export', request()->query()) . '" class="btn btn-light border btn-sm"><i class="ri-download-line me-1"></i> تصدير CSV</a>',
])
<div class="row g-3 mb-4">
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-file-list-line', 'label' => 'الإجمالي', 'value' => number_format($stats['total']), 'hint' => number_format($stats['filtered']) . ' حسب الفلاتر'])
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'orange', 'icon' => 'ri-time-line', 'label' => 'قيد الانتظار', 'value' => number_format($stats['pending']), 'hint' => 'بانتظار المراجعة'])
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-check-line', 'label' => 'مقبول', 'value' => number_format($stats['accepted']), 'hint' => 'طلبات مقبولة'])
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'cyan', 'icon' => 'ri-close-line', 'label' => 'مرفوض', 'value' => number_format($stats['rejected']), 'hint' => 'طلبات مرفوضة'])
</div>
<div class="filter-panel mb-4">
    <form method="GET" class="row g-2 align-items-end">
        <div class="col-md-3"><input type="text" name="search" class="form-control" placeholder="بحث..." value="{{ request('search') }}"></div>
        <div class="col-md-2">
            <select name="status" class="form-select"><option value="">كل الحالات</option>
                @foreach($statuses as $status)<option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-3">
            <select name="cycle_id" class="form-select"><option value="">كل الدورات</option>
                @foreach($cycles as $cycle)<option value="{{ $cycle->id }}" @selected(request('cycle_id') == $cycle->id)>{{ $cycle->name }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2">
            <select name="program_id" class="form-select"><option value="">كل البرامج</option>
                @foreach($programs as $program)<option value="{{ $program->id }}" @selected(request('program_id') == $program->id)>{{ $program->name }}</option>@endforeach
            </select>
        </div>
        <div class="col-md-2 d-flex gap-2"><button class="btn btn-primary">بحث</button><a href="{{ route('admin.admission.applications.index') }}" class="btn btn-light border">مسح</a></div>
    </form>
</div>
<div class="card custom-card"><div class="card-body p-0">
<table class="table data-table mb-0">
<thead><tr><th>#</th><th>المرجع</th><th>الاسم</th><th>البرنامج</th><th>الدورة</th><th>الحالة</th><th>التاريخ</th><th>إجراءات</th></tr></thead>
<tbody>
@forelse($applications as $application)
<tr>
    <td>{{ $applications->firstItem() + $loop->index }}</td>
    <td dir="ltr">{{ $application->reference_number }}</td>
    <td>{{ $application->full_name }}</td>
    <td>{{ $application->program?->name ?: '—' }}</td>
    <td>{{ $application->cycle?->name ?: '—' }}</td>
    <td><span class="badge {{ $application->status?->badgeClass() }}">{{ $application->status?->label() }}</span></td>
    <td>{{ $application->created_at?->format('Y-m-d') }}</td>
    <td><a href="{{ route('admin.admission.applications.show', $application) }}" class="btn btn-sm btn-light"><i class="ri-eye-line"></i></a></td>
</tr>
@empty
<tr><td colspan="8" class="text-center py-4 text-muted">لا توجد طلبات</td></tr>
@endforelse
</tbody></table>
@if($applications->hasPages())<div class="card-footer">{{ $applications->links() }}</div>@endif
</div></div>
</div></div>
@endsection
