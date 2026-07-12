@extends('doctor.layouts.master')

@section('page-title')
لوحة التحكم
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        <div class="dashboard-welcome mb-4">
            <h4 class="dashboard-welcome__title mb-1">
                مرحباً {{ auth()->user()->name }}، أهلاً بعودتك!
            </h4>
            <p class="dashboard-welcome__subtitle mb-0">
                أنت مسجل الدخول كـ {{ $roleLabel }}
                @if($currentTerm) · {{ $currentTerm->name }} @endif
            </p>
        </div>

        <div class="row g-3 mb-4">
            @include('admin.partials.ui.stat-card-gradient', [
                'variant' => 'cyan',
                'icon' => 'ri-book-2-line',
                'label' => 'شعب الفصل',
                'value' => $stats['sections_count'],
                'hint' => $stats['current_term'],
            ])
            @include('admin.partials.ui.stat-card-gradient', [
                'variant' => 'orange',
                'icon' => 'ri-group-line',
                'label' => 'الطلاب',
                'value' => $stats['students_count'],
                'hint' => 'مسجّلون في شعبك',
            ])
            @include('admin.partials.ui.stat-card-gradient', [
                'variant' => 'purple',
                'icon' => 'ri-file-list-3-line',
                'label' => 'درجات بانتظار النشر',
                'value' => $stats['unpublished_grades'],
                'hint' => 'جاهزة ولما تُنشر بعد',
            ])
            @include('admin.partials.ui.stat-card-gradient', [
                'variant' => 'green',
                'icon' => 'ri-calendar-schedule-line',
                'label' => 'الجدول',
                'value' => 'أسبوعي',
                'hint' => 'محاضراتك لهذا الفصل',
            ])
        </div>

        <div class="row g-3 mb-4">
            <div class="col-auto">
                <a href="{{ route('doctor.sections.index') }}" class="btn btn-primary btn-sm">الشعب الدراسية</a>
            </div>
            <div class="col-auto">
                <a href="{{ route('doctor.schedule.index') }}" class="btn btn-outline-primary btn-sm">الجدول الأسبوعي</a>
            </div>
            <div class="col-auto">
                <a href="{{ route('doctor.profile.show') }}" class="btn btn-light border btn-sm">الملف الشخصي</a>
            </div>
        </div>

        <div class="card custom-card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold">شعب الفصل الحالي</h6>
                <a href="{{ route('doctor.sections.index') }}" class="btn btn-sm btn-primary">عرض الكل</a>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0 align-middle">
                        <thead>
                            <tr>
                                <th>المقرر</th>
                                <th>الشعبة</th>
                                <th>الوقت</th>
                                <th>الطلاب</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sections as $section)
                                <tr>
                                    <td>{{ $section->programCourse->code ?? '' }} — {{ $section->programCourse->name ?? '—' }}</td>
                                    <td>{{ $section->section_code }}</td>
                                    <td>{{ $section->days_label }} · {{ $section->time_range }}</td>
                                    <td>{{ $section->enrolled_count }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('doctor.sections.show', $section) }}" class="btn btn-sm btn-outline-primary">إدارة</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">لا توجد شعب في الفصل الحالي.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
