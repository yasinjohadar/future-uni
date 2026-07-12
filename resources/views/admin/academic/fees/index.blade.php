@extends('admin.layouts.master')
@section('page-title') الرسوم @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'الرسوم']],
    'title' => 'فواتير الرسوم', 'subtitle' => 'إدارة رسوم الطلاب',
    'actions' => '<a href="' . route('admin.academic.fees.create') . '" class="btn btn-link text-primary fw-bold text-decoration-none p-0"><i class="ri-add-circle-line me-1"></i> فاتورة جديدة</a>',
])
<div class="row g-3 mb-4">
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-money-dollar-circle-line', 'label' => 'إجمالي الفواتير', 'value' => number_format($stats['total']), 'hint' => number_format($stats['filtered']) . ' حسب الفلاتر'])
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'orange', 'icon' => 'ri-time-line', 'label' => 'مستحقة', 'value' => number_format($stats['pending']), 'hint' => ''])
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-checkbox-circle-line', 'label' => 'مدفوعة', 'value' => number_format($stats['paid']), 'hint' => ''])
</div>
<div class="filter-panel mb-4"><form method="GET" class="row g-2">
    <div class="col-md-4"><input name="search" class="form-control" placeholder="بحث..." value="{{ request('search') }}"></div>
    <div class="col-md-3"><select name="status" class="form-select"><option value="">كل الحالات</option>@foreach($statuses as $st)<option value="{{ $st->value }}" @selected(request('status')==$st->value)>{{ $st->label() }}</option>@endforeach</select></div>
    <div class="col-md-5 d-flex gap-2"><button class="btn btn-primary">بحث</button><a href="{{ route('admin.academic.fees.index') }}" class="btn btn-light border">مسح</a></div>
</form></div>
<div class="card custom-card"><div class="card-body p-0"><table class="table data-table mb-0">
<thead><tr><th>#</th><th>الطالب</th><th>العنوان</th><th>المبلغ</th><th>المدفوع</th><th>المتبقي</th><th>الحالة</th><th>إجراءات</th></tr></thead>
<tbody>@forelse($invoices as $invoice)
<tr>
    <td>{{ $invoices->firstItem() + $loop->index }}</td>
    <td>{{ $invoice->student?->user?->name }} <small class="text-muted">({{ $invoice->student?->student_number }})</small></td>
    <td><a href="{{ route('admin.academic.fees.show', $invoice) }}" class="fw-bold text-decoration-none">{{ $invoice->title }}</a></td>
    <td>{{ number_format($invoice->amount, 2) }}</td>
    <td>{{ number_format($invoice->paid_amount, 2) }}</td>
    <td>{{ number_format($invoice->remaining(), 2) }}</td>
    <td>{{ $invoice->status->label() }}</td>
    <td>
        <a href="{{ route('admin.academic.fees.show', $invoice) }}" class="btn btn-sm btn-light"><i class="ri-eye-line"></i></a>
        <form action="{{ route('admin.academic.fees.destroy', $invoice) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف؟')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i></button></form>
    </td>
</tr>@empty<tr><td colspan="8" class="text-center py-4 text-muted">لا توجد فواتير</td></tr>@endforelse</tbody>
</table>@if($invoices->hasPages())<div class="card-footer">{{ $invoices->links() }}</div>@endif</div></div>
</div></div>
@endsection
