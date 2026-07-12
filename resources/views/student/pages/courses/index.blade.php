@extends('student.layouts.master')

@section('page-title')
مقرراتي
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        <div class="dashboard-welcome mb-4">
            <h4 class="dashboard-welcome__title mb-1">مقرراتي</h4>
            <p class="dashboard-welcome__subtitle mb-0">
                @if($currentTerm)
                    مقررات الفصل: {{ $currentTerm->name }}
                @else
                    لا يوجد فصل دراسي حالي
                @endif
            </p>
        </div>

        <div class="card custom-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>رمز المقرر</th>
                                <th>اسم المقرر</th>
                                <th>الشعبة</th>
                                <th>المدرس</th>
                                <th>الأيام</th>
                                <th>الوقت</th>
                                <th>القاعة</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($enrollments as $enrollment)
                                @php $section = $enrollment->courseSection; @endphp
                                <tr>
                                    <td>{{ $section->programCourse->code ?? '—' }}</td>
                                    <td>{{ $section->programCourse->name ?? '—' }}</td>
                                    <td>{{ $section->section_code }}</td>
                                    <td>{{ $section->instructor_name }}</td>
                                    <td>{{ $section->days_label }}</td>
                                    <td>{{ $section->time_range }}</td>
                                    <td>{{ $section->room ?? '—' }}</td>
                                    <td>
                                        <span class="badge bg-primary-transparent">{{ $enrollment->status->label() }}</span>
                                        @if($enrollment->grade?->isPublished())
                                            <span class="badge bg-success-transparent">{{ $enrollment->grade->letter }}</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted py-4">لا توجد مقررات مسجّلة في الفصل الحالي.</td>
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
