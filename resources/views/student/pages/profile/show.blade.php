@extends('student.layouts.master')

@section('page-title')
الملف الشخصي
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        <div class="dashboard-welcome mb-4">
            <h4 class="dashboard-welcome__title mb-1">الملف الشخصي</h4>
            <p class="dashboard-welcome__subtitle mb-0">البيانات الأكاديمية ومعلومات التواصل</p>
        </div>

        <div class="row g-3">
            <div class="col-lg-6">
                <div class="card custom-card h-100">
                    <div class="card-header">
                        <h6 class="mb-0 fw-semibold">الهوية الأكاديمية</h6>
                    </div>
                    <div class="card-body">
                        <p class="mb-2"><strong>الرقم الجامعي:</strong> {{ $student->student_number }}</p>
                        <p class="mb-2"><strong>الكلية:</strong> {{ $student->program?->college?->name ?? '—' }}</p>
                        <p class="mb-2"><strong>البرنامج:</strong> {{ $student->program?->name ?? '—' }}</p>
                        <p class="mb-2"><strong>حالة التسجيل:</strong> {{ $student->status }}</p>
                        <p class="mb-0"><strong>تاريخ الالتحاق:</strong> {{ $student->enrollment_date?->translatedFormat('d F Y') ?? '—' }}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card custom-card h-100">
                    <div class="card-header">
                        <h6 class="mb-0 fw-semibold">تحديث البيانات</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('student.profile.update') }}">
                            @csrf
                            @method('PATCH')

                            <div class="mb-3">
                                <label class="form-label">الاسم</label>
                                <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">البريد الإلكتروني</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" disabled>
                                <small class="text-muted">لتغيير البريد تواصل مع الإدارة.</small>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">الهاتف</label>
                                <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
                            </div>

                            <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
