@extends('admin.layouts.master')
@section('page-title') الشعب الدراسية @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'الشعب الدراسية']],
    'title' => 'الشعب الدراسية', 'subtitle' => 'إدارة شعب المقررات',
    'actions' => '<a href="' . route('admin.academic.sections.create') . '" class="btn btn-link text-primary fw-bold text-decoration-none p-0"><i class="ri-add-circle-line me-1"></i> إضافة شعبة</a>',
])
<div class="row g-3 mb-4">
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-group-line', 'label' => 'إجمالي الشعب', 'value' => number_format($stats['total']), 'hint' => number_format($stats['filtered']) . ' حسب الفلاتر'])
    @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-checkbox-circle-line', 'label' => 'نشطة', 'value' => number_format($stats['active']), 'hint' => ''])
</div>
<div class="filter-panel mb-4"><form method="GET" class="row g-2">
    <div class="col-md-3"><input name="search" class="form-control" placeholder="بحث..." value="{{ request('search') }}"></div>
    <div class="col-md-3"><select name="academic_term_id" class="form-select"><option value="">كل الفصول</option>@foreach($terms as $t)<option value="{{ $t->id }}" @selected(request('academic_term_id')==$t->id)>{{ $t->name }}</option>@endforeach</select></div>
    <div class="col-md-3"><select name="program_course_id" class="form-select"><option value="">كل المقررات</option>@foreach($programCourses as $pc)<option value="{{ $pc->id }}" @selected(request('program_course_id')==$pc->id)>{{ $pc->code }} — {{ $pc->name }}</option>@endforeach</select></div>
    <div class="col-md-3 d-flex gap-2"><button class="btn btn-primary">بحث</button><a href="{{ route('admin.academic.sections.index') }}" class="btn btn-light border">مسح</a></div>
</form></div>
<div class="card custom-card"><div class="card-body p-0"><table class="table data-table mb-0">
<thead><tr><th>#</th><th>المقرر</th><th>الشعبة</th><th>الفصل</th><th>الأيام</th><th>الوقت</th><th>المحاضر</th><th>السعة</th><th>إجراءات</th></tr></thead>
<tbody>@forelse($sections as $section)
<tr>
    <td>{{ $sections->firstItem() + $loop->index }}</td>
    <td>{{ $section->programCourse?->code }} — {{ $section->programCourse?->name }}</td>
    <td>{{ $section->section_code }}</td>
    <td>{{ $section->academicTerm?->name }}</td>
    <td>{{ $section->days_label }}</td>
    <td>{{ $section->time_range }}</td>
    <td>{{ $section->instructor_name }}</td>
    <td>{{ $section->enrolledCount() }}/{{ $section->capacity }}</td>
    <td>
        <a href="{{ route('admin.academic.sections.edit', $section) }}" class="btn btn-sm btn-light"><i class="ri-pencil-line"></i></a>
        <form action="{{ route('admin.academic.sections.destroy', $section) }}" method="POST" class="d-inline" onsubmit="return confirm('حذف؟')">@csrf @method('DELETE')<button class="btn btn-sm btn-danger"><i class="ri-delete-bin-line"></i></button></form>
    </td>
</tr>@empty<tr><td colspan="9" class="text-center py-4 text-muted">لا توجد شعب</td></tr>@endforelse</tbody>
</table>@if($sections->hasPages())<div class="card-footer">{{ $sections->links() }}</div>@endif</div></div>
</div></div>
@endsection
