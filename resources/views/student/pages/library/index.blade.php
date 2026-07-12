@extends('student.layouts.master')

@section('page-title')
المكتبة
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        <div class="dashboard-welcome mb-4">
            <h4 class="dashboard-welcome__title mb-1">المكتبة</h4>
            <p class="dashboard-welcome__subtitle mb-0">سجل الاستعارات</p>
        </div>

        @include('admin.partials.ui.stat-card-gradient', [
            'col' => 'col-sm-6 col-xl-4 mb-4',
            'variant' => 'purple',
            'icon' => 'ri-book-read-line',
            'label' => 'استعارات نشطة',
            'value' => $activeLoansCount,
            'hint' => 'كتب غير مُرجعة',
        ])

        <div class="card custom-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>الكتاب</th>
                                <th>المؤلف</th>
                                <th>تاريخ الاستعارة</th>
                                <th>تاريخ الإرجاع</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($loans as $loan)
                                <tr>
                                    <td>{{ $loan->book->title ?? '—' }}</td>
                                    <td>{{ $loan->book->author ?? '—' }}</td>
                                    <td>{{ $loan->borrowed_at?->translatedFormat('d F Y') ?? '—' }}</td>
                                    <td>{{ $loan->due_at?->translatedFormat('d F Y') ?? '—' }}</td>
                                    <td><span class="badge bg-primary-transparent">{{ $loan->status->label() }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">لا توجد استعارات.</td>
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
