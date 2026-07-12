@extends('doctor.layouts.master')

@section('page-title')
الملف الشخصي
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        <div class="dashboard-welcome mb-4">
            <h4 class="dashboard-welcome__title mb-1">الملف الشخصي</h4>
            <p class="dashboard-welcome__subtitle mb-0">بيانات التواصل والشعب المسندة</p>
        </div>

        <div class="row g-3">
            <div class="col-lg-6">
                <div class="card custom-card h-100">
                    <div class="card-header">
                        <h6 class="mb-0 fw-semibold">تحديث البيانات</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('doctor.profile.update') }}">
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

            <div class="col-lg-6">
                <div class="card custom-card h-100">
                    <div class="card-header">
                        <h6 class="mb-0 fw-semibold">
                            شعبِي
                            @if($currentTerm)
                                <span class="text-muted fw-normal fs-13">({{ $currentTerm->name }})</span>
                            @endif
                        </h6>
                    </div>
                    <div class="card-body">
                        @forelse($sections as $section)
                            <div class="{{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }}">
                                <strong>{{ $section->programCourse->code ?? '' }} — {{ $section->programCourse->name ?? '—' }}</strong>
                                <div class="text-muted fs-13">شعبة {{ $section->section_code }} · {{ $section->days_label }}</div>
                            </div>
                        @empty
                            <p class="mb-0 text-muted">لا توجد شعب مسندة.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
