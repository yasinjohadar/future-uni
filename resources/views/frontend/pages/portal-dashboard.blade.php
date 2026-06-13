@extends('frontend.layouts.master')

@section('title', 'لوحة الطالب | جامعة المستقبل')

@section('content')
<section class="py-5">
    <div class="container">
        <div class="uni-card p-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold mb-1">مرحباً، {{ $student->user?->name }}</h2>
                    <p class="text-secondary mb-0">رقم الطالب: {{ $student->student_number }}</p>
                </div>
                <form method="POST" action="{{ route('portal.logout') }}">@csrf<button class="btn btn-glass btn-sm">تسجيل الخروج</button></form>
            </div>
            <div class="row g-3">
                <div class="col-md-4"><div class="uni-card p-3"><strong>البرنامج</strong><p class="mb-0 text-secondary">{{ $student->program?->name ?? 'غير محدد' }}</p></div></div>
                <div class="col-md-4"><div class="uni-card p-3"><strong>الكلية</strong><p class="mb-0 text-secondary">{{ $student->program?->college?->name ?? '—' }}</p></div></div>
                <div class="col-md-4"><div class="uni-card p-3"><strong>الحالة</strong><p class="mb-0 text-secondary">{{ $student->status }}</p></div></div>
            </div>
            <p class="text-secondary small mt-4 mb-0">مرحلة SIS Lite — التسجيل في المقررات والجداول قادمة في تحديث لاحق.</p>
        </div>
    </div>
</section>
@endsection
