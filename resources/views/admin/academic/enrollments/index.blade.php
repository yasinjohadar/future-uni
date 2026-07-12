@extends('admin.layouts.master')
@section('page-title') التسجيلات @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'التسجيلات']],
    'title' => 'تسجيلات الطلاب', 'subtitle' => 'إدارة تسجيل الشعب',
    'actions' => '<a href="' . route('admin.academic.enrollments.create') . '" class="btn btn-link text-primary fw-bold text-decoration-none p-0"><i class="ri-add-circle-line me-1"></i> تسجيل جديد</a>',
])
<div class="row g-3 mb-4">
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-user-add-line', 'label' => 'إجمالي التسجيلات', 'value' => number_format($stats['total']), 'hint' => number_format($stats['filtered']) . ' حسب الفلاتر'])
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-checkbox-circle-line', 'label' => 'مسجّلون', 'value' => number_format($stats['enrolled']), 'hint' => ''])
</div>
<div class="filter-panel mb-4"><form method="GET" class="row g-2">
    <div class="col-md-3"><input name="search" class="form-control" placeholder="بحث بالطالب..." value="{{ request('search') }}"></div>
    <div class="col-md-4"><select name="course_section_id" class="form-select"><option value="">كل الشعب</option>@foreach($sections as $s)<option value="{{ $s->id }}" @selected(request('course_section_id')==$s->id)>{{ $s->programCourse?->code }} — {{ $s->section_code }} ({{ $s->academicTerm?->name }})</option>@endforeach</select></div>
    <div class="col-md-2"><select name="status" class="form-select"><option value="">كل الحالات</option>@foreach($statuses as $st)<option value="{{ $st->value }}" @selected(request('status')==$st->value)>{{ $st->label() }}</option>@endforeach</select></div>
    <div class="col-md-3 d-flex gap-2"><button class="btn btn-primary">بحث</button><a href="{{ route('admin.academic.enrollments.index') }}" class="btn btn-light border">مسح</a></div>
</form></div>
<div class="card custom-card"><div class="card-body p-0"><table class="table data-table mb-0">
<thead><tr><th>#</th><th>الطالب</th><th>المقرر / الشعبة</th><th>الفصل</th><th>الحالة</th><th>الدرجة</th><th>إجراءات</th></tr></thead>
<tbody>@forelse($enrollments as $enrollment)
<tr>
    <td>{{ $enrollments->firstItem() + $loop->index }}</td>
    <td>{{ $enrollment->student?->user?->name }} <small class="text-muted">({{ $enrollment->student?->student_number }})</small></td>
    <td>{{ $enrollment->courseSection?->programCourse?->name }} — {{ $enrollment->courseSection?->section_code }}</td>
    <td>{{ $enrollment->courseSection?->academicTerm?->name }}</td>
    <td>{{ $enrollment->status->label() }}</td>
    <td>@if($enrollment->grade){{ $enrollment->grade->total ?? '—' }} @if($enrollment->grade->isPublished())<span class="badge bg-success">منشورة</span>@endif @else—@endif</td>
    <td>
        <a href="{{ route('admin.academic.enrollments.show', $enrollment) }}" class="btn btn-sm btn-light"><i class="ri-eye-line"></i></a>
        <form action="{{ route('admin.academic.enrollments.destroy', $enrollment) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف؟')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i></button></form>
    </td>
</tr>@empty<tr><td colspan="7" class="text-center py-4 text-muted">لا توجد تسجيلات</td></tr>@endforelse</tbody>
</table>@if($enrollments->hasPages())<div class="card-footer">{{ $enrollments->links() }}</div>@endif</div></div>
</div></div>
@endsection
