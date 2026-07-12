@extends('doctor.layouts.master')

@section('page-title')
{{ $section->programCourse->name ?? 'الشعبة' }}
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        <div class="dashboard-welcome mb-4">
            <h4 class="dashboard-welcome__title mb-1">
                {{ $section->programCourse->code ?? '' }} — {{ $section->programCourse->name ?? '—' }}
            </h4>
            <p class="dashboard-welcome__subtitle mb-0">
                شعبة {{ $section->section_code }} · {{ $section->academicTerm->name ?? '—' }}
                · {{ $section->days_label }} · {{ $section->time_range }}
                @if($section->room) · {{ $section->room }} @endif
            </p>
        </div>

        <div class="d-flex flex-wrap gap-2 mb-4">
            <a href="{{ route('doctor.sections.index') }}" class="btn btn-light border btn-sm">
                <i class="ri-arrow-right-line me-1"></i> العودة للشعب
            </a>
            <a href="{{ route('doctor.sections.export', $section) }}" class="btn btn-outline-secondary btn-sm">
                <i class="ri-download-2-line me-1"></i> تصدير CSV
            </a>
            <form method="POST" action="{{ route('doctor.sections.publish-all-grades', $section) }}">
                @csrf
                <button type="submit" class="btn btn-success btn-sm">نشر كل الدرجات الجاهزة</button>
            </form>
            <a href="{{ route('doctor.attendance.create', $section) }}" class="btn btn-primary btn-sm">
                <i class="ri-user-follow-line me-1"></i> جلسة حضور
            </a>
        </div>

        <div class="card custom-card mb-4">
            <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-2">
                <h6 class="mb-0 fw-semibold">الطلاب والدرجات</h6>
                <form method="GET" action="{{ route('doctor.sections.show', $section) }}" class="d-flex gap-2">
                    <input type="text" name="q" value="{{ $search }}" class="form-control form-control-sm" placeholder="بحث بالاسم أو الرقم الجامعي" style="min-width:220px">
                    <button type="submit" class="btn btn-sm btn-outline-primary">بحث</button>
                    @if($search !== '')
                        <a href="{{ route('doctor.sections.show', $section) }}" class="btn btn-sm btn-light border">مسح</a>
                    @endif
                </form>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>الرقم الجامعي</th>
                                <th>الاسم</th>
                                <th>الحضور</th>
                                <th>الدرجات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enrollments as $enrollment)
                                @php
                                    $grade = $enrollment->grade;
                                    $att = $attendanceSummary[$enrollment->id] ?? null;
                                @endphp
                                <tr>
                                    <td>{{ $enrollment->student->student_number ?? '—' }}</td>
                                    <td>{{ $enrollment->student->user->name ?? '—' }}</td>
                                    <td>
                                        @if($att)
                                            <span class="badge bg-info-transparent">{{ $att['present'] }}/{{ $att['total'] }} ({{ $att['percent'] }}%)</span>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                    <td class="p-2">
                                        @if($grade)
                                            <div class="d-flex flex-wrap gap-2 align-items-center">
                                                <form method="POST" action="{{ route('doctor.grades.update', $grade) }}" class="d-flex flex-wrap gap-2 align-items-center">
                                                    @csrf
                                                    @method('PATCH')
                                                    <input type="number" step="0.01" min="0" max="100" name="midterm"
                                                           class="form-control form-control-sm" style="width:90px"
                                                           value="{{ old('midterm', $grade->midterm) }}" placeholder="منتصف">
                                                    <input type="number" step="0.01" min="0" max="100" name="final"
                                                           class="form-control form-control-sm" style="width:90px"
                                                           value="{{ old('final', $grade->final) }}" placeholder="نهائي">
                                                    <span class="badge bg-secondary-transparent">{{ $grade->total ?? '—' }}</span>
                                                    <span class="badge bg-primary-transparent">{{ $grade->letter ?? '—' }}</span>
                                                    @if($grade->isPublished())
                                                        <span class="badge bg-success-transparent">منشور</span>
                                                    @else
                                                        <span class="badge bg-warning-transparent">مسودة</span>
                                                    @endif
                                                    <button type="submit" class="btn btn-sm btn-outline-primary">حفظ</button>
                                                </form>
                                                @if(!$grade->isPublished() && $grade->total !== null)
                                                    <form method="POST" action="{{ route('doctor.grades.publish', $grade) }}">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-success">نشر</button>
                                                    </form>
                                                @endif
                                            </div>
                                        @else
                                            <span class="text-muted">—</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center text-muted py-4">لا يوجد طلاب مسجّلون.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="row g-3">
            <div class="col-lg-6">
                <div class="card custom-card h-100">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0 fw-semibold">جلسات الحضور</h6>
                        <a href="{{ route('doctor.attendance.create', $section) }}" class="btn btn-sm btn-primary">جديد</a>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <thead>
                                    <tr>
                                        <th>التاريخ</th>
                                        <th>العنوان</th>
                                        <th>السجلات</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($attendanceSessions as $session)
                                        <tr>
                                            <td>{{ $session->session_date?->format('Y-m-d') }}</td>
                                            <td>{{ $session->title ?: '—' }}</td>
                                            <td>{{ $session->records_count }}</td>
                                            <td class="text-end">
                                                <a href="{{ route('doctor.attendance.edit', [$section, $session]) }}" class="btn btn-sm btn-outline-primary">تعديل</a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center text-muted py-3">لا توجد جلسات بعد.</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card custom-card h-100">
                    <div class="card-header">
                        <h6 class="mb-0 fw-semibold">إعلان للشعبة</h6>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('doctor.announcements.store', $section) }}" class="mb-4">
                            @csrf
                            <div class="mb-2">
                                <input type="text" name="title" class="form-control" placeholder="عنوان الإعلان" required value="{{ old('title') }}">
                            </div>
                            <div class="mb-2">
                                <textarea name="body" class="form-control" rows="3" placeholder="نص الإعلان" required>{{ old('body') }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary btn-sm">نشر للطلاب</button>
                        </form>

                        @forelse($announcements as $announcement)
                            <div class="border rounded p-3 mb-2">
                                <div class="d-flex justify-content-between gap-2">
                                    <strong>{{ $announcement->title }}</strong>
                                    <form method="POST" action="{{ route('doctor.announcements.destroy', [$section, $announcement]) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" onclick="return confirm('حذف الإعلان؟')">حذف</button>
                                    </form>
                                </div>
                                <p class="mb-1 fs-13 text-muted">{{ $announcement->published_at?->diffForHumans() }}</p>
                                <p class="mb-0">{{ $announcement->body }}</p>
                            </div>
                        @empty
                            <p class="mb-0 text-muted">لا توجد إعلانات لهذه الشعبة.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
