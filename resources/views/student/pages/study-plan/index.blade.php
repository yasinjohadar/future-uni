@extends('student.layouts.master')

@section('page-title')
الخطة الدراسية
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        <div class="dashboard-welcome mb-4">
            <h4 class="dashboard-welcome__title mb-1">الخطة الدراسية</h4>
            <p class="dashboard-welcome__subtitle mb-0">{{ $student->program?->name ?? '—' }}</p>
        </div>

        <div class="row g-3 mb-4">
            @include('admin.partials.ui.stat-card-gradient', [
                'col' => 'col-sm-4',
                'variant' => 'green',
                'icon' => 'ri-checkbox-circle-line',
                'label' => 'مكتمل',
                'value' => $statusCounts['completed'],
                'hint' => 'مقررات ناجحة',
            ])
            @include('admin.partials.ui.stat-card-gradient', [
                'col' => 'col-sm-4',
                'variant' => 'cyan',
                'icon' => 'ri-book-open-line',
                'label' => 'مسجّل',
                'value' => $statusCounts['enrolled'],
                'hint' => 'الفصل الحالي',
            ])
            @include('admin.partials.ui.stat-card-gradient', [
                'col' => 'col-sm-4',
                'variant' => 'orange',
                'icon' => 'ri-time-line',
                'label' => 'متبقّي',
                'value' => $statusCounts['remaining'],
                'hint' => 'لم يُنجَز بعد',
            ])
        </div>

        <div class="card custom-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>الفصل</th>
                                <th>الرمز</th>
                                <th>المقرر</th>
                                <th>الساعات</th>
                                <th>النوع</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($courses as $item)
                                @php
                                    $statusBadge = match($item->status) {
                                        'completed' => ['bg-success-transparent', 'مكتمل'],
                                        'enrolled' => ['bg-primary-transparent', 'مسجّل'],
                                        default => ['bg-secondary-transparent', 'متبقّي'],
                                    };
                                @endphp
                                <tr>
                                    <td>{{ $item->course->semester ?? '—' }}</td>
                                    <td>{{ $item->course->code }}</td>
                                    <td>{{ $item->course->name }}</td>
                                    <td>{{ $item->course->credits }}</td>
                                    <td>{{ $item->course->type ?? '—' }}</td>
                                    <td><span class="badge {{ $statusBadge[0] }}">{{ $statusBadge[1] }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">لا توجد مقررات في الخطة الدراسية.</td>
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
