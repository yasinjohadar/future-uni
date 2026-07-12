@extends('student.layouts.master')

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
                أنت مسجل الدخول كـ {{ $roleLabel }} — {{ $stats['current_term'] }}
            </p>
        </div>

        <div class="row g-3 mb-4">
            @include('admin.partials.ui.stat-card-gradient', [
                'variant' => 'purple',
                'icon' => 'ri-book-open-line',
                'label' => 'مقررات الفصل',
                'value' => $stats['active_enrollments'],
                'hint' => 'مسجّل حالياً',
            ])
            @include('admin.partials.ui.stat-card-gradient', [
                'variant' => 'green',
                'icon' => 'ri-medal-line',
                'label' => 'المعدل التراكمي',
                'value' => $stats['cumulative_gpa'],
                'hint' => 'GPA',
            ])
            @include('admin.partials.ui.stat-card-gradient', [
                'variant' => 'cyan',
                'icon' => 'ri-bar-chart-line',
                'label' => 'معدل الفصل',
                'value' => $stats['term_gpa'],
                'hint' => 'الفصل الحالي',
            ])
            @include('admin.partials.ui.stat-card-gradient', [
                'variant' => 'orange',
                'icon' => 'ri-wallet-3-line',
                'label' => 'الرصيد المستحق',
                'value' => $stats['outstanding_balance'],
                'hint' => 'رسوم دراسية',
            ])
        </div>

        <div class="row g-3 mb-4">
            @include('admin.partials.ui.stat-card-gradient', [
                'col' => 'col-sm-6 col-xl-3',
                'variant' => 'purple',
                'icon' => 'ri-hashtag',
                'label' => 'الرقم الجامعي',
                'value' => $stats['student_number'],
                'hint' => $stats['program'],
            ])
            @include('admin.partials.ui.stat-card-gradient', [
                'col' => 'col-sm-6 col-xl-3',
                'variant' => 'green',
                'icon' => 'ri-checkbox-circle-line',
                'label' => 'حالة التسجيل',
                'value' => $stats['status'],
                'hint' => $stats['college'],
            ])
            @include('admin.partials.ui.stat-card-gradient', [
                'col' => 'col-sm-6 col-xl-3',
                'variant' => 'cyan',
                'icon' => 'ri-percent-line',
                'label' => 'متوسط الدرجات',
                'value' => $stats['grade_average'],
                'hint' => 'الدرجات المنشورة',
            ])
            @include('admin.partials.ui.stat-card-gradient', [
                'col' => 'col-sm-6 col-xl-3',
                'variant' => 'orange',
                'icon' => 'ri-calendar-line',
                'label' => 'تاريخ الالتحاق',
                'value' => $stats['enrollment_date'],
                'hint' => 'بداية الدراسة',
            ])
        </div>

        <div class="card custom-card">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h6 class="mb-0 fw-semibold">آخر الإعلانات</h6>
                <a href="{{ route('student.announcements.index') }}" class="btn btn-sm btn-light border">عرض الكل</a>
            </div>
            <div class="card-body">
                @forelse($announcements as $announcement)
                    <div class="{{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }}">
                        <h6 class="mb-1">{{ $announcement->title }}</h6>
                        <p class="text-muted fs-13 mb-1">{{ \Illuminate\Support\Str::limit(strip_tags($announcement->body), 120) }}</p>
                        <small class="text-muted">{{ $announcement->published_at?->translatedFormat('d F Y') }}</small>
                    </div>
                @empty
                    <p class="mb-0 text-muted">لا توجد إعلانات حالياً.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
