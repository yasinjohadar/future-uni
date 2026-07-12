@extends('admin.layouts.master')
@section('page-title') تعديل إعلان @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'الإعلانات', 'url' => route('admin.academic.announcements.index')], ['label' => 'تعديل']],
    'title' => 'تعديل: ' . $announcement->title,
    'actions' => '<a href="' . route('admin.academic.announcements.index') . '" class="btn btn-light border"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
])
<form action="{{ route('admin.academic.announcements.update', $announcement) }}" method="POST">
@csrf @method('PUT')
<div class="card custom-card"><div class="card-body">
    <div class="row g-3">
        <div class="col-12"><label class="form-label">العنوان *</label><input type="text" name="title" class="form-control" value="{{ old('title', $announcement->title) }}" required></div>
        <div class="col-12"><label class="form-label">النص *</label><textarea name="body" class="form-control" rows="6" required>{{ old('body', $announcement->body) }}</textarea></div>
        <div class="col-md-4"><label class="form-label">الجمهور *</label><select name="audience" class="form-select" required><option value="all" @selected(old('audience', $announcement->audience)==='all')>الجميع</option><option value="college" @selected(old('audience', $announcement->audience)==='college')>كلية محددة</option><option value="program" @selected(old('audience', $announcement->audience)==='program')>برنامج محدد</option></select></div>
        <div class="col-md-4"><label class="form-label">الكلية</label><select name="college_id" class="form-select"><option value="">—</option>@foreach($colleges as $c)<option value="{{ $c->id }}" @selected(old('college_id', $announcement->college_id)==$c->id)>{{ $c->name }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">البرنامج</label><select name="program_id" class="form-select"><option value="">—</option>@foreach($programs as $p)<option value="{{ $p->id }}" @selected(old('program_id', $announcement->program_id)==$p->id)>{{ $p->name }}</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">تاريخ النشر</label><input type="datetime-local" name="published_at" class="form-control" value="{{ old('published_at', $announcement->published_at?->format('Y-m-d\TH:i')) }}"></div>
        <div class="col-md-4 d-flex align-items-end"><div class="form-check"><input type="checkbox" name="publish_now" value="1" class="form-check-input" id="publish_now"><label class="form-check-label" for="publish_now">نشر فوراً</label></div></div>
        <div class="col-md-4 d-flex align-items-end"><div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" @checked(old('is_active', $announcement->is_active))><label class="form-check-label" for="is_active">نشط</label></div></div>
    </div>
</div><div class="card-footer"><button type="submit" class="btn btn-primary">حفظ التعديلات</button></div></div>
</form>
</div></div>
@endsection
