@extends('admin.layouts.master')
@section('page-title') الاستعارات @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'المكتبة'], ['label' => 'الاستعارات']],
    'title' => 'استعارات المكتبة', 'subtitle' => 'إدارة استعارة الكتب',
    'actions' => '<a href="' . route('admin.library.loans.create') . '" class="btn btn-link text-primary fw-bold text-decoration-none p-0"><i class="ri-add-circle-line me-1"></i> استعارة جديدة</a>',
])
<div class="row g-3 mb-4">
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-book-read-line', 'label' => 'إجمالي الاستعارات', 'value' => number_format($stats['total']), 'hint' => number_format($stats['filtered']) . ' حسب الفلاتر'])
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'orange', 'icon' => 'ri-time-line', 'label' => 'نشطة', 'value' => number_format($stats['active']), 'hint' => ''])
</div>
<div class="filter-panel mb-4"><form method="GET" class="row g-2">
    <div class="col-md-4"><input name="search" class="form-control" placeholder="بحث بالطالب أو الكتاب..." value="{{ request('search') }}"></div>
    <div class="col-md-3"><select name="status" class="form-select"><option value="">كل الحالات</option>@foreach($statuses as $st)<option value="{{ $st->value }}" @selected(request('status')==$st->value)>{{ $st->label() }}</option>@endforeach</select></div>
    <div class="col-md-5 d-flex gap-2"><button class="btn btn-primary">بحث</button><a href="{{ route('admin.library.loans.index') }}" class="btn btn-light border">مسح</a></div>
</form></div>
<div class="card custom-card"><div class="card-body p-0"><table class="table data-table mb-0">
<thead><tr><th>#</th><th>الطالب</th><th>الكتاب</th><th>الاستعارة</th><th>الاستحقاق</th><th>الإرجاع</th><th>الحالة</th><th>إجراءات</th></tr></thead>
<tbody>@forelse($loans as $loan)
<tr>
    <td>{{ $loans->firstItem() + $loop->index }}</td>
    <td>{{ $loan->student?->user?->name }} <small class="text-muted">({{ $loan->student?->student_number }})</small></td>
    <td>{{ $loan->book?->title }}</td>
    <td>{{ $loan->borrowed_at?->format('Y-m-d') }}</td>
    <td>{{ $loan->due_at?->format('Y-m-d') ?? '—' }}</td>
    <td>{{ $loan->returned_at?->format('Y-m-d') ?? '—' }}</td>
    <td>{{ $loan->status->label() }}</td>
    <td>
        @if($loan->status->value !== 'returned')
        <form action="{{ route('admin.library.loans.return', $loan) }}" method="POST" class="d-inline" onsubmit="return confirm('تأكيد إرجاع الكتاب؟')">@csrf<button class="btn btn-sm btn-success">إرجاع</button></form>
        @else—@endif
    </td>
</tr>@empty<tr><td colspan="8" class="text-center py-4 text-muted">لا توجد استعارات</td></tr>@endforelse</tbody>
</table>@if($loans->hasPages())<div class="card-footer">{{ $loans->links() }}</div>@endif</div></div>
</div></div>
@endsection
