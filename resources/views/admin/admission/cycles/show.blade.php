@extends('admin.layouts.master')
@section('page-title') {{ $cycle->name }} @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'دورات القبول', 'url' => route('admin.admission.cycles.index')], ['label' => $cycle->name]],
    'title' => $cycle->name,
    'subtitle' => $cycle->academic_year,
    'actions' => '<a href="' . route('admin.admission.cycles.edit', $cycle) . '" class="btn btn-primary btn-sm">تعديل</a>',
])
<div class="row g-3 mb-4">
    <div class="col-md-4"><div class="card"><div class="card-body text-center"><div class="fs-20 fw-bold">{{ $cycle->applications_count }}</div><div class="text-muted">طلبات</div></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body text-center"><div class="fs-20 fw-bold">{{ $cycle->is_open ? 'مفتوحة' : 'مغلقة' }}</div><div class="text-muted">الحالة</div></div></div></div>
    <div class="col-md-4"><div class="card"><div class="card-body text-center"><div class="fs-20 fw-bold">{{ $cycle->start_date?->format('Y-m-d') ?: '—' }}</div><div class="text-muted">تاريخ البداية</div></div></div></div>
</div>
<div class="card custom-card mb-4"><div class="card-body">
    <p><strong>الوصف:</strong> {{ $cycle->description ?: '—' }}</p>
    <p><strong>الفترة:</strong> {{ $cycle->start_date?->format('Y-m-d') ?: '—' }} — {{ $cycle->end_date?->format('Y-m-d') ?: '—' }}</p>
</div></div>
@if($cycle->applications->isNotEmpty())
<div class="card custom-card"><div class="card-header d-flex justify-content-between">
    <h6 class="mb-0">آخر الطلبات</h6>
    <a href="{{ route('admin.admission.applications.index', ['cycle_id' => $cycle->id]) }}">عرض الكل</a>
</div><div class="card-body p-0"><table class="table mb-0"><thead><tr><th>المرجع</th><th>الاسم</th><th>الحالة</th></tr></thead><tbody>
@foreach($cycle->applications as $app)
<tr>
    <td><a href="{{ route('admin.admission.applications.show', $app) }}">{{ $app->reference_number }}</a></td>
    <td>{{ $app->full_name }}</td>
    <td>{{ $app->status?->label() }}</td>
</tr>
@endforeach
</tbody></table></div></div>
@endif
</div></div>
@endsection
