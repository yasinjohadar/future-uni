@extends('admin.layouts.master')
@section('page-title') فاتورة جديدة @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'الرسوم', 'url' => route('admin.academic.fees.index')], ['label' => 'إضافة']],
    'title' => 'إنشاء فاتورة رسوم',
    'actions' => '<a href="' . route('admin.academic.fees.index') . '" class="btn btn-light border"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
])
<form action="{{ route('admin.academic.fees.store') }}" method="POST">
@csrf
<div class="card custom-card"><div class="card-body">
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">الطالب *</label><select name="student_id" class="form-select" required><option value="">اختر الطالب</option>@foreach($students as $s)<option value="{{ $s->id }}" @selected(old('student_id', $selectedStudentId)==$s->id)>{{ $s->user?->name }} ({{ $s->student_number }})</option>@endforeach</select></div>
        <div class="col-md-6"><label class="form-label">عنوان الفاتورة *</label><input type="text" name="title" class="form-control" value="{{ old('title') }}" required></div>
        <div class="col-md-4"><label class="form-label">المبلغ *</label><input type="number" name="amount" class="form-control" step="0.01" min="0.01" value="{{ old('amount') }}" required></div>
        <div class="col-md-4"><label class="form-label">تاريخ الاستحقاق</label><input type="date" name="due_date" class="form-control" value="{{ old('due_date') }}"></div>
        <div class="col-12"><label class="form-label">ملاحظات</label><textarea name="notes" class="form-control" rows="3">{{ old('notes') }}</textarea></div>
    </div>
</div><div class="card-footer"><button type="submit" class="btn btn-primary">حفظ</button></div></div>
</form>
</div></div>
@endsection
