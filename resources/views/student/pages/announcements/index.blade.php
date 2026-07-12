@extends('student.layouts.master')

@section('page-title')
الإعلانات
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        <div class="dashboard-welcome mb-4">
            <h4 class="dashboard-welcome__title mb-1">الإعلانات</h4>
            <p class="dashboard-welcome__subtitle mb-0">إعلانات موجهة لك</p>
        </div>

        @forelse($announcements as $announcement)
            <div class="card custom-card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="mb-0 fw-semibold">{{ $announcement->title }}</h6>
                        <small class="text-muted">{{ $announcement->published_at?->translatedFormat('d F Y') }}</small>
                    </div>
                    <div class="text-muted">{!! nl2br(e($announcement->body)) !!}</div>
                </div>
            </div>
        @empty
            <div class="card custom-card">
                <div class="card-body text-center text-muted py-5">لا توجد إعلانات.</div>
            </div>
        @endforelse

        @if($announcements->hasPages())
            <div class="d-flex justify-content-center">
                {{ $announcements->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
