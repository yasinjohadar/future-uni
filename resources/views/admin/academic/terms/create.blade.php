@extends('admin.layouts.master')
@section('page-title') إضافة فصل دراسي @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'الفصول الدراسية', 'url' => route('admin.academic.terms.index')], ['label' => 'إضافة']],
    'title' => 'إضافة فصل دراسي',
    'actions' => '<a href="' . route('admin.academic.terms.index') . '" class="btn btn-light border"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
])
<form action="{{ route('admin.academic.terms.store') }}" method="POST">
@csrf
<div class="card custom-card"><div class="card-body">
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">الاسم *</label><input type="text" name="name" class="form-control" value="{{ old('name') }}" required></div>
        <div class="col-md-6"><label class="form-label">الرمز *</label><input type="text" name="code" class="form-control" value="{{ old('code') }}" required></div>
        <div class="col-md-6"><label class="form-label">تاريخ البداية</label><input type="date" name="starts_at" class="form-control" value="{{ old('starts_at') }}"></div>
        <div class="col-md-6"><label class="form-label">تاريخ النهاية</label><input type="date" name="ends_at" class="form-control" value="{{ old('ends_at') }}"></div>
        <div class="col-md-6"><label class="form-label">فتح التسجيل</label><input type="datetime-local" name="registration_opens_at" class="form-control" value="{{ old('registration_opens_at') }}"></div>
        <div class="col-md-6"><label class="form-label">إغلاق التسجيل</label><input type="datetime-local" name="registration_closes_at" class="form-control" value="{{ old('registration_closes_at') }}"></div>
        <div class="col-12"><div class="form-check"><input type="checkbox" name="is_active" value="1" class="form-check-input" id="is_active" @checked(old('is_active', true))><label class="form-check-label" for="is_active">نشط</label></div></div>
    </div>
</div><div class="card-footer"><button type="submit" class="btn btn-primary">حفظ</button></div></div>
</form>
</div></div>
@endsection
