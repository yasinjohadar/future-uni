@extends('admin.layouts.master')
@section('page-title') تفاصيل التسجيل @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'التسجيلات', 'url' => route('admin.academic.enrollments.index')], ['label' => 'تفاصيل']],
    'title' => 'تفاصيل التسجيل',
    'actions' => '<a href="' . route('admin.academic.enrollments.index') . '" class="btn btn-light border"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
])
<div class="row g-4">
    <div class="col-lg-6">
        <div class="card custom-card"><div class="card-header fw-bold">بيانات التسجيل</div><div class="card-body">
            <p><strong>الطالب:</strong> {{ $enrollment->student?->user?->name }} ({{ $enrollment->student?->student_number }})</p>
            <p><strong>البرنامج:</strong> {{ $enrollment->student?->program?->name }}</p>
            <p><strong>المقرر:</strong> {{ $enrollment->courseSection?->programCourse?->name }}</p>
            <p><strong>الشعبة:</strong> {{ $enrollment->courseSection?->section_code }}</p>
            <p><strong>الفصل:</strong> {{ $enrollment->courseSection?->academicTerm?->name }}</p>
            <p><strong>المحاضر:</strong> {{ $enrollment->courseSection?->instructor_name }}</p>
            <p><strong>الحالة:</strong> {{ $enrollment->status->label() }}</p>
            <p><strong>تاريخ التسجيل:</strong> {{ $enrollment->enrolled_at?->format('Y-m-d H:i') ?? '—' }}</p>
        </div></div>
    </div>
    <div class="col-lg-6">
        <div class="card custom-card"><div class="card-header fw-bold">الدرجات</div><div class="card-body">
            <form action="{{ route('admin.academic.enrollments.grade', $enrollment) }}" method="POST" class="mb-3">
                @csrf @method('PUT')
                <div class="row g-2">
                    <div class="col-md-4"><label class="form-label">منتصف الفصل</label><input type="number" name="midterm" class="form-control" step="0.01" min="0" max="100" value="{{ old('midterm', $enrollment->grade?->midterm) }}"></div>
                    <div class="col-md-4"><label class="form-label">نهاية الفصل</label><input type="number" name="final" class="form-control" step="0.01" min="0" max="100" value="{{ old('final', $enrollment->grade?->final) }}"></div>
                    <div class="col-md-4 d-flex align-items-end"><button type="submit" class="btn btn-primary w-100">حفظ الدرجات</button></div>
                </div>
            </form>
            @if($enrollment->grade)
            <p><strong>المجموع:</strong> {{ $enrollment->grade->total ?? '—' }}</p>
            <p><strong>التقدير:</strong> {{ $enrollment->grade->letter ?? '—' }}</p>
            <p><strong>النشر:</strong> @if($enrollment->grade->isPublished())<span class="badge bg-success">منشورة</span> ({{ $enrollment->grade->published_at->format('Y-m-d H:i') }})@else<span class="badge bg-secondary">غير منشورة</span>@endif</p>
            <div class="d-flex gap-2">
                @unless($enrollment->grade->isPublished())
                <form action="{{ route('admin.academic.enrollments.publish-grade', $enrollment) }}" method="POST">@csrf<button class="btn btn-success btn-sm">نشر الدرجة</button></form>
                @else
                <form action="{{ route('admin.academic.enrollments.unpublish-grade', $enrollment) }}" method="POST">@csrf<button class="btn btn-warning btn-sm">إلغاء النشر</button></form>
                @endunless
            </div>
            @else
            <p class="text-muted">لم تُدخل درجات بعد.</p>
            @endif
        </div></div>
    </div>
</div>
</div></div>
@endsection
