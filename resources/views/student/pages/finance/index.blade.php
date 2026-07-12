@extends('student.layouts.master')

@section('page-title')
المالية
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        <div class="dashboard-welcome mb-4">
            <h4 class="dashboard-welcome__title mb-1">المالية</h4>
            <p class="dashboard-welcome__subtitle mb-0">فواتير الرسوم والمدفوعات</p>
        </div>

        @include('admin.partials.ui.stat-card-gradient', [
            'col' => 'col-sm-6 col-xl-4 mb-4',
            'variant' => 'orange',
            'icon' => 'ri-wallet-3-line',
            'label' => 'إجمالي المستحق',
            'value' => number_format($totalOutstanding, 2),
            'hint' => 'رصيد غير مدفوع',
        ])

        <div class="card custom-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>العنوان</th>
                                <th>المبلغ</th>
                                <th>المدفوع</th>
                                <th>المتبقي</th>
                                <th>تاريخ الاستحقاق</th>
                                <th>الحالة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($invoices as $invoice)
                                <tr>
                                    <td>{{ $invoice->title }}</td>
                                    <td>{{ number_format($invoice->amount, 2) }}</td>
                                    <td>{{ number_format($invoice->paid_amount, 2) }}</td>
                                    <td>{{ number_format($invoice->remaining(), 2) }}</td>
                                    <td>{{ $invoice->due_date?->translatedFormat('d F Y') ?? '—' }}</td>
                                    <td><span class="badge bg-primary-transparent">{{ $invoice->status->label() }}</span></td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">لا توجد فواتير.</td>
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
