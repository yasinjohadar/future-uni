@extends('admin.layouts.master')
@section('page-title') البرامج @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'البرامج']],
    'title' => 'البرامج الأكاديمية', 'subtitle' => 'إدارة برامج الدراسة',
    'actions' => '<a href="' . route('admin.academic.programs.create') . '" class="btn btn-link text-primary fw-bold text-decoration-none p-0"><i class="ri-add-circle-line me-1"></i> إضافة برنامج</a>',
])
<div class="row g-3 mb-4">
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-graduation-cap-line', 'label' => 'إجمالي البرامج', 'value' => number_format($stats['total']), 'hint' => number_format($stats['filtered']) . ' حسب الفلاتر'])
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-checkbox-circle-line', 'label' => 'نشطة', 'value' => number_format($stats['active']), 'hint' => ''])
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'cyan', 'icon' => 'ri-pause-circle-line', 'label' => 'غير نشطة', 'value' => number_format($stats['inactive']), 'hint' => ''])
</div>
<div class="filter-panel mb-4"><form method="GET" class="row g-2">
    <div class="col-md-3"><input name="search" class="form-control" placeholder="بحث..." value="{{ request('search') }}"></div>
    <div class="col-md-3"><select name="college_id" class="form-select"><option value="">كل الكليات</option>@foreach($colleges as $c)<option value="{{ $c->id }}" @selected(request('college_id')==$c->id)>{{ $c->name }}</option>@endforeach</select></div>
    <div class="col-md-2"><select name="level" class="form-select"><option value="">كل المستويات</option>@foreach($levels as $l)<option value="{{ $l->value }}" @selected(request('level')==$l->value)>{{ $l->label() }}</option>@endforeach</select></div>
    <div class="col-md-4 d-flex gap-2"><button class="btn btn-primary">بحث</button><a href="{{ route('admin.academic.programs.index') }}" class="btn btn-light border">مسح</a></div>
</form></div>
<div class="card custom-card"><div class="card-body p-0"><table class="table data-table mb-0">
<thead><tr><th>#</th><th>الاسم</th><th>الكلية</th><th>المستوى</th><th>الحالة</th><th>إجراءات</th></tr></thead>
<tbody>@forelse($programs as $program)
<tr>
    <td>{{ $programs->firstItem() + $loop->index }}</td>
    <td><a href="{{ route('admin.academic.programs.edit', $program) }}" class="fw-bold text-decoration-none">{{ $program->name }}</a></td>
    <td>{{ $program->college?->name }}</td>
    <td>{{ $program->level_label }}</td>
    <td>{{ $program->is_active ? 'نشط' : 'غير نشط' }}</td>
    <td>
        <a href="{{ route('admin.academic.programs.show', $program) }}" class="btn btn-sm btn-light"><i class="ri-eye-line"></i></a>
        <a href="{{ route('admin.academic.programs.edit', $program) }}" class="btn btn-sm btn-light"><i class="ri-pencil-line"></i></a>
        <form action="{{ route('admin.academic.programs.toggle-active', $program) }}" method="POST" class="d-inline">@csrf<button class="btn btn-sm btn-light"><i class="ri-toggle-line"></i></button></form>
        <form action="{{ route('admin.academic.programs.destroy', $program) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف؟')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i></button></form>
    </td>
</tr>@empty<tr><td colspan="6" class="text-center py-4 text-muted">لا توجد برامج</td></tr>@endforelse</tbody>
</table>@if($programs->hasPages())<div class="card-footer">{{ $programs->links() }}</div>@endif</div></div>
</div></div>
@endsection
