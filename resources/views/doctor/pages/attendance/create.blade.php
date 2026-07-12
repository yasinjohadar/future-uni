@extends('doctor.layouts.master')

@section('page-title')
جلسة حضور جديدة
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        <div class="dashboard-welcome mb-4">
            <h4 class="dashboard-welcome__title mb-1">جلسة حضور</h4>
            <p class="dashboard-welcome__subtitle mb-0">
                {{ $section->programCourse->code ?? '' }} — {{ $section->programCourse->name ?? '—' }} · شعبة {{ $section->section_code }}
            </p>
        </div>

        <div class="card custom-card" style="max-width:560px">
            <div class="card-body">
                <form method="POST" action="{{ route('doctor.attendance.store', $section) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">تاريخ الجلسة</label>
                        <input type="date" name="session_date" class="form-control" value="{{ old('session_date', now()->toDateString()) }}" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">العنوان (اختياري)</label>
                        <input type="text" name="title" class="form-control" value="{{ old('title') }}" placeholder="مثال: محاضرة الأسبوع 3">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">ملاحظة</label>
                        <textarea name="note" class="form-control" rows="2">{{ old('note') }}</textarea>
                    </div>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">إنشاء ومتابعة التسجيل</button>
                        <a href="{{ route('doctor.sections.show', $section) }}" class="btn btn-light border">إلغاء</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
