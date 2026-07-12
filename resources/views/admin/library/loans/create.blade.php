@extends('admin.layouts.master')
@section('page-title') استعارة جديدة @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'الاستعارات', 'url' => route('admin.library.loans.index')], ['label' => 'إضافة']],
    'title' => 'تسجيل استعارة كتاب',
    'actions' => '<a href="' . route('admin.library.loans.index') . '" class="btn btn-light border"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
])
<form action="{{ route('admin.library.loans.store') }}" method="POST">
@csrf
<div class="card custom-card"><div class="card-body">
    <div class="row g-3">
        <div class="col-md-6"><label class="form-label">الطالب *</label><select name="student_id" class="form-select" required><option value="">اختر الطالب</option>@foreach($students as $s)<option value="{{ $s->id }}" @selected(old('student_id', $selectedStudentId)==$s->id)>{{ $s->user?->name }} ({{ $s->student_number }})</option>@endforeach</select></div>
        <div class="col-md-6"><label class="form-label">الكتاب *</label><select name="library_book_id" class="form-select" required><option value="">اختر الكتاب</option>@foreach($books as $b)<option value="{{ $b->id }}" @selected(old('library_book_id', $selectedBookId)==$b->id)>{{ $b->title }} (متاح: {{ $b->copies_available }})</option>@endforeach</select></div>
        <div class="col-md-4"><label class="form-label">تاريخ الاستعارة</label><input type="datetime-local" name="borrowed_at" class="form-control" value="{{ old('borrowed_at') }}"></div>
        <div class="col-md-4"><label class="form-label">تاريخ الاستحقاق</label><input type="datetime-local" name="due_at" class="form-control" value="{{ old('due_at') }}"></div>
        <div class="col-12"><label class="form-label">ملاحظات</label><textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea></div>
    </div>
</div><div class="card-footer"><button type="submit" class="btn btn-primary">حفظ</button></div></div>
</form>
</div></div>
@endsection
