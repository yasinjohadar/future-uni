@extends('student.layouts.master')

@section('page-title')
الدرجات
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        <div class="dashboard-welcome mb-4">
            <h4 class="dashboard-welcome__title mb-1">الدرجات</h4>
            <p class="dashboard-welcome__subtitle mb-0">الدرجات المنشورة فقط</p>
        </div>

        <div class="row g-3 mb-4">
            @include('admin.partials.ui.stat-card-gradient', [
                'col' => 'col-sm-6',
                'variant' => 'green',
                'icon' => 'ri-medal-line',
                'label' => 'المعدل التراكمي',
                'value' => $cumulativeGpa !== null ? number_format($cumulativeGpa, 2) : '—',
                'hint' => 'GPA',
            ])
            @include('admin.partials.ui.stat-card-gradient', [
                'col' => 'col-sm-6',
                'variant' => 'cyan',
                'icon' => 'ri-bar-chart-line',
                'label' => 'معدل الفصل الحالي',
                'value' => $termGpa !== null ? number_format($termGpa, 2) : '—',
                'hint' => $currentTerm?->name ?? '—',
            ])
        </div>

        <div class="card custom-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>الفصل</th>
                                <th>المقرر</th>
                                <th>الساعات</th>
                                <th>منتصف</th>
                                <th>نهائي</th>
                                <th>المجموع</th>
                                <th>التقدير</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($grades as $grade)
                                @php
                                    $section = $grade->enrollment->courseSection;
                                    $course = $section->programCourse;
                                @endphp
                                <tr>
                                    <td>{{ $section->academicTerm->name ?? '—' }}</td>
                                    <td>{{ $course->code ?? '' }} — {{ $course->name ?? '—' }}</td>
                                    <td>{{ $course->credits ?? '—' }}</td>
                                    <td>{{ $grade->midterm ?? '—' }}</td>
                                    <td>{{ $grade->final ?? '—' }}</td>
                                    <td>{{ $grade->total ?? '—' }}</td>
                                    <td><span class="badge bg-primary-transparent">{{ $grade->letter ?? '—' }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">لا توجد درجات منشورة.</td>
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
