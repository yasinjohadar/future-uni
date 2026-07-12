@extends('admin.layouts.master')
@section('page-title') تفاصيل الفاتورة @stop
@section('content')
<div class="main-content app-content"><div class="container-fluid">
@include('admin.partials.ui.alerts')
@include('admin.partials.ui.page-header', [
    'breadcrumbs' => [['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')], ['label' => 'الرسوم', 'url' => route('admin.academic.fees.index')], ['label' => 'تفاصيل']],
    'title' => $invoice->title,
    'actions' => '<a href="' . route('admin.academic.fees.index') . '" class="btn btn-light border"><i class="ri-arrow-right-line me-1"></i> رجوع</a>',
])
<div class="row g-4">
    <div class="col-lg-5">
        <div class="card custom-card"><div class="card-header fw-bold">بيانات الفاتورة</div><div class="card-body">
            <p><strong>الطالب:</strong> {{ $invoice->student?->user?->name }} ({{ $invoice->student?->student_number }})</p>
            <p><strong>المبلغ:</strong> {{ number_format($invoice->amount, 2) }}</p>
            <p><strong>المدفوع:</strong> {{ number_format($invoice->paid_amount, 2) }}</p>
            <p><strong>المتبقي:</strong> {{ number_format($invoice->remaining(), 2) }}</p>
            <p><strong>الحالة:</strong> {{ $invoice->status->label() }}</p>
            <p><strong>الاستحقاق:</strong> {{ $invoice->due_date?->format('Y-m-d') ?? '—' }}</p>
            @if($invoice->notes)<p><strong>ملاحظات:</strong> {{ $invoice->notes }}</p>@endif
        </div></div>
    </div>
    <div class="col-lg-7">
        @if($invoice->remaining() > 0 && $invoice->status->value !== 'cancelled')
        <div class="card custom-card mb-4"><div class="card-header fw-bold">تسجيل دفعة</div><div class="card-body">
            <form action="{{ route('admin.academic.fees.payments', $invoice) }}" method="POST">
                @csrf
                <div class="row g-2">
                    <div class="col-md-3"><label class="form-label">المبلغ *</label><input type="number" name="amount" class="form-control" step="0.01" min="0.01" max="{{ $invoice->remaining() }}" required></div>
                    <div class="col-md-3"><label class="form-label">التاريخ</label><input type="datetime-local" name="paid_at" class="form-control"></div>
                    <div class="col-md-3"><label class="form-label">طريقة الدفع</label><input type="text" name="method" class="form-control" placeholder="نقدي / تحويل..."></div>
                    <div class="col-md-3 d-flex align-items-end"><button type="submit" class="btn btn-success w-100">تسجيل الدفعة</button></div>
                    <div class="col-12"><label class="form-label">ملاحظة</label><input type="text" name="note" class="form-control"></div>
                </div>
            </form>
        </div></div>
        @endif
        <div class="card custom-card"><div class="card-header fw-bold">سجل الدفعات</div><div class="card-body p-0">
            <table class="table mb-0"><thead><tr><th>التاريخ</th><th>المبلغ</th><th>الطريقة</th><th>بواسطة</th><th>ملاحظة</th></tr></thead>
            <tbody>@forelse($invoice->payments as $payment)
            <tr>
                <td>{{ $payment->paid_at?->format('Y-m-d H:i') ?? '—' }}</td>
                <td>{{ number_format($payment->amount, 2) }}</td>
                <td>{{ $payment->method ?? '—' }}</td>
                <td>{{ $payment->recorder?->name ?? '—' }}</td>
                <td>{{ $payment->note ?? '—' }}</td>
            </tr>@empty<tr><td colspan="5" class="text-center py-3 text-muted">لا توجد دفعات</td></tr>@endforelse</tbody>
            </table>
        </div></div>
    </div>
</div>
</div></div>
@endsection
