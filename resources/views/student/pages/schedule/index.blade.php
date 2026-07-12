@extends('student.layouts.master')

@section('page-title')
الجدول الدراسي
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        <div class="dashboard-welcome mb-4">
            <h4 class="dashboard-welcome__title mb-1">الجدول الدراسي</h4>
            <p class="dashboard-welcome__subtitle mb-0">
                @if($currentTerm)
                    {{ $currentTerm->name }}
                @else
                    لا يوجد فصل دراسي حالي
                @endif
            </p>
        </div>

        <div class="row g-3">
            @foreach($grid as $day => $dayData)
                <div class="col-md-6 col-xl-4">
                    <div class="card custom-card h-100">
                        <div class="card-header">
                            <h6 class="mb-0 fw-semibold">{{ $dayData['label'] }}</h6>
                        </div>
                        <div class="card-body">
                            @forelse($dayData['slots'] as $section)
                                <div class="{{ !$loop->last ? 'mb-3 pb-3 border-bottom' : '' }}">
                                    <strong>{{ $section->programCourse->name ?? '—' }}</strong>
                                    <div class="text-muted fs-13">{{ $section->programCourse->code ?? '' }} — شعبة {{ $section->section_code }}</div>
                                    <div class="fs-13">{{ $section->time_range }} @if($section->room) · {{ $section->room }} @endif</div>
                                </div>
                            @empty
                                <p class="mb-0 text-muted">لا توجد محاضرات</p>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection
