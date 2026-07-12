@extends('doctor.layouts.master')

@section('page-title')
الشعب الدراسية
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        <div class="dashboard-welcome mb-4">
            <h4 class="dashboard-welcome__title mb-1">الشعب الدراسية</h4>
            <p class="dashboard-welcome__subtitle mb-0">الشعب المسندة إليك</p>
        </div>

        <div class="card custom-card">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>الفصل</th>
                                <th>المقرر</th>
                                <th>الشعبة</th>
                                <th>الطلاب</th>
                                <th>السعة</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($sections as $section)
                                <tr>
                                    <td>{{ $section->academicTerm->name ?? '—' }}</td>
                                    <td>{{ $section->programCourse->code ?? '' }} — {{ $section->programCourse->name ?? '—' }}</td>
                                    <td>{{ $section->section_code }}</td>
                                    <td>{{ $section->enrolled_count }}</td>
                                    <td>{{ $section->capacity }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('doctor.sections.show', $section) }}" class="btn btn-sm btn-primary">التفاصيل</a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center text-muted py-4">لا توجد شعب مسندة إليك.</td>
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
