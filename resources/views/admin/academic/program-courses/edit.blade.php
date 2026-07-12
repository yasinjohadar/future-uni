@extends('admin.layouts.master')
@section('page-title') تعديل مقرر @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'مقررات البرامج', 'url' => route('admin.academic.program-courses.index')], ['label' => 'تعديل']],
    'title' => 'تعديل: ' . $course->name,
    'actions' => '<a href="' . route('admin.academic.program-courses.index') . '" class="btn btn-light border"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
])
<form action="{{ route('admin.academic.program-courses.update', $course) }}" method="POST">
@csrf @method('PUT')
<div class="card custom-card"><div class="card-body">
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">البرنامج *</label><select name="program_id" class="form-select" required>@foreach($programs as $p)<option value="{{ $p->id }}" @selected(old('program_id', $course->program_id)==$p->id)>{{ $p->name }}</option>@endforeach</select></div>
        <div class="col-md-3"><label class="form-label">الرمز *</label><input type="text" name="code" class="form-control" value="{{ old('code', $course->code) }}" required></div>
        <div class="col-md-3"><label class="form-label">الساعات</label><input type="number" name="credits" class="form-control" value="{{ old('credits', $course->credits) }}" min="1"></div>
        <div class="col-md-8"><label class="form-label">اسم المقرر *</label><input type="text" name="name" class="form-control" value="{{ old('name', $course->name) }}" required></div>
        <div class="col-md-2"><label class="form-label">الفصل الدراسي</label><input type="number" name="semester" class="form-control" value="{{ old('semester', $course->semester) }}" min="1"></div>
        <div class="col-md-2"><label class="form-label">النوع</label><select name="type" class="form-select"><option value="core" @selected(old('type', $course->type)==='core')>إجباري</option><option value="elective" @selected(old('type', $course->type)==='elective')>اختياري</option></select></div>
        <div class="col-md-4"><label class="form-label">الترتيب</label><input type="number" name="sort_order" class="form-control" value="{{ old('sort_order', $course->sort_order) }}" min="0"></div>
    </div>
</div><div class="card-footer"><button type="submit" class="btn btn-primary">حفظ التعديلات</button></div></div>
</form>
</div></div>
@endsection
