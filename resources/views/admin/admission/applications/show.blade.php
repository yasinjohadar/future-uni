@extends('admin.layouts.master')
@section('page-title') طلب {{ $application->reference_number }} @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'طلبات القبول', 'url' => route('admin.admission.applications.index')], ['label' => $application->reference_number]],
    'title' => $application->full_name,
    'subtitle' => $application->reference_number,
    'actions' => '<a href="' . route('admin.admission.applications.index') . '" class="btn btn-light border">رجوع</a>',
])
<div class="row g-4">
    <div class="col-lg-8">
        <div class="card custom-card mb-4"><div class="card-header"><h6 class="mb-0">بيانات المتقدم</h6></div><div class="card-body">
            <div class="row g-3">
                <div class="col-md-6"><label class="text-muted small">البريد الإلكتروني</label><p><a href="mailto:{{ $application->email }}">{{ $application->email }}</a></p></div>
                <div class="col-md-6"><label class="text-muted small">الهاتف</label><p>{{ $application->phone ?: '—' }}</p></div>
                <div class="col-md-6"><label class="text-muted small">رقم الهوية</label><p>{{ $application->national_id ?: '—' }}</p></div>
                <div class="col-md-6"><label class="text-muted small">تاريخ الميلاد</label><p>{{ $application->birth_date?->format('Y-m-d') ?: '—' }}</p></div>
                <div class="col-md-6"><label class="text-muted small">الجنس</label><p>{{ $application->gender ?: '—' }}</p></div>
                <div class="col-md-6"><label class="text-muted small">المعدل</label><p>{{ $application->high_school_gpa ?: '—' }}</p></div>
                <div class="col-md-6"><label class="text-muted small">المدينة</label><p>{{ $application->city ?: '—' }}</p></div>
                <div class="col-md-6"><label class="text-muted small">تاريخ التقديم</label><p>{{ $application->created_at?->format('Y-m-d H:i') }}</p></div>
            </div>
        </div></div>
        <div class="card custom-card"><div class="card-header"><h6 class="mb-0">البرنامج والدورة</h6></div><div class="card-body">
            <p><strong>البرنامج:</strong> {{ $application->program?->name ?: '—' }} ({{ $application->program?->college?->name }})</p>
            <p><strong>الدورة:</strong> {{ $application->cycle?->name ?: '—' }} — {{ $application->cycle?->academic_year }}</p>
            @if($application->notes)<p><strong>ملاحظات:</strong> {{ $application->notes }}</p>@endif
        </div></div>
    </div>
    <div class="col-lg-4">
        <div class="card custom-card"><div class="card-header"><h6 class="mb-0">تحديث الحالة</h6></div><div class="card-body">
            <p class="mb-3">الحالة الحالية: <span class="badge {{ $application->status?->badgeClass() }}">{{ $application->status?->label() }}</span></p>
            <form action="{{ route('admin.admission.applications.update-status', $application) }}" method="POST">@csrf @method('PATCH')
                <div class="mb-3">
                    <label class="form-label">الحالة الجديدة</label>
                    <select name="status" class="form-select" required>
                        @foreach($statuses as $status)<option value="{{ $status->value }}" @selected(old('status', $application->status?->value) === $status->value)>{{ $status->label() }}</option>@endforeach
                    </select>
                </div>
                <div class="mb-3"><label class="form-label">ملاحظات</label><textarea name="notes" class="form-control" rows="3">{{ old('notes', $application->notes) }}</textarea></div>
                <button type="submit" class="btn btn-primary w-100">حفظ الحالة</button>
            </form>
        </div></div>
    </div>
</div>
</div></div>
@endsection
