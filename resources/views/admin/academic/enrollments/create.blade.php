@extends('admin.layouts.master')
@section('page-title') تسجيل جديد @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'التسجيلات', 'url' => route('admin.academic.enrollments.index')], ['label' => 'إضافة']],
    'title' => 'تسجيل طالب في شعبة',
    'actions' => '<a href="' . route('admin.academic.enrollments.index') . '" class="btn btn-light border"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
])
<form action="{{ route('admin.academic.enrollments.store') }}" method="POST">
@csrf
<div class="card custom-card"><div class="card-body">
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">الطالب *</label><select name="student_id" class="form-select" required><option value="">اختر الطالب</option>@foreach($students as $s)<option value="{{ $s->id }}" @selected(old('student_id', $selectedStudentId)==$s->id)>{{ $s->user?->name }} ({{ $s->student_number }})</option>@endforeach</select></div>
        <div class="col-md-6"><label class="form-label">الشعبة *</label><select name="course_section_id" class="form-select" required><option value="">اختر الشعبة</option>@foreach($sections as $sec)<option value="{{ $sec->id }}" @selected(old('course_section_id', $selectedSectionId)==$sec->id)>{{ $sec->programCourse?->code }} — {{ $sec->section_code }} / {{ $sec->academicTerm?->name }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">الحالة *</label><select name="status" class="form-select" required>@foreach($statuses as $st)<option value="{{ $st->value }}" @selected(old('status', 'enrolled')==$st->value)>{{ $st->label() }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">تاريخ التسجيل</label><input type="datetime-local" name="enrolled_at" class="form-control" value="{{ old('enrolled_at') }}"></div>
    </div>
</div><div class="card-footer"><button type="submit" class="btn btn-primary">حفظ</button></div></div>
</form>
</div></div>
@endsection
