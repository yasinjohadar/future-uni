@extends('admin.layouts.master')
@section('page-title') مقررات البرامج @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'مقررات البرامج']],
    'title' => 'مقررات البرامج', 'subtitle' => 'إدارة مقررات الدراسة',
    'actions' => '<a href="' . route('admin.academic.program-courses.create', ['program_id' => request('program_id')]) . '" class="btn btn-link text-primary fw-bold text-decoration-none p-0"><i class="ri-add-circle-line me-1"></i> إضافة مقرر</a>',
])
<div class="row g-3 mb-4">
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-book-open-line', 'label' => 'إجمالي المقررات', 'value' => number_format($stats['total']), 'hint' => number_format($stats['filtered']) . ' حسب الفلاتر'])
</div>
<div class="filter-panel mb-4"><form method="GET" class="row g-2">
    <div class="col-md-3"><input name="search" class="form-control" placeholder="بحث..." value="{{ request('search') }}"></div>
    <div class="col-md-4"><select name="program_id" class="form-select"><option value="">كل البرامج</option>@foreach($programs as $p)<option value="{{ $p->id }}" @selected(request('program_id')==$p->id)>{{ $p->name }}</option>@endforeach</select></div>
    <div class="col-md-5 d-flex gap-2"><button class="btn btn-primary">بحث</button><a href="{{ route('admin.academic.program-courses.index') }}" class="btn btn-light border">مسح</a></div>
</form></div>
<div class="card custom-card"><div class="card-body p-0"><table class="table data-table mb-0">
<thead><tr><th>#</th><th>الرمز</th><th>الاسم</th><th>البرنامج</th><th>الساعات</th><th>الفصل</th><th>النوع</th><th>إجراءات</th></tr></thead>
<tbody>@forelse($courses as $course)
<tr>
    <td>{{ $courses->firstItem() + $loop->index }}</td>
    <td>{{ $course->code }}</td>
    <td><a href="{{ route('admin.academic.program-courses.edit', $course) }}" class="fw-bold text-decoration-none">{{ $course->name }}</a></td>
    <td>{{ $course->program?->name }}</td>
    <td>{{ $course->credits }}</td>
    <td>{{ $course->semester ?? '—' }}</td>
    <td>{{ $course->type }}</td>
    <td>
        <a href="{{ route('admin.academic.program-courses.edit', $course) }}" class="btn btn-sm btn-light"><i class="ri-pencil-line"></i></a>
        <form action="{{ route('admin.academic.program-courses.destroy', $course) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف؟')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i></button></form>
    </td>
</tr>@empty<tr><td colspan="8" class="text-center py-4 text-muted">لا توجد مقررات</td></tr>@endforelse</tbody>
</table>@if($courses->hasPages())<div class="card-footer">{{ $courses->links() }}</div>@endif</div></div>
</div></div>
@endsection
