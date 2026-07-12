@extends('student.layouts.master')

@section('page-title')
التسجيل
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        <div class="dashboard-welcome mb-4">
            <h4 class="dashboard-welcome__title mb-1">التسجيل في المقررات</h4>
            <p class="dashboard-welcome__subtitle mb-0">
                @if($currentTerm)
                    {{ $currentTerm->name }} —
                    @if($registrationOpen)
                        <span class="text-success">التسجيل مفتوح</span>
                    @else
                        <span class="text-danger">التسجيل مغلق</span>
                    @endif
                @else
                    لا يوجد فصل دراسي حالي
                @endif
            </p>
        </div>

        @if($currentEnrollments->isNotEmpty())
            <div class="card custom-card mb-4">
                <div class="card-header">
                    <h6 class="mb-0 fw-semibold">مقرراتي المسجّلة</h6>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>المقرر</th>
                                    <th>الشعبة</th>
                                    <th>المدرس</th>
                                    @if($registrationOpen)
                                        <th></th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($currentEnrollments as $enrollment)
                                    @php $section = $enrollment->courseSection; @endphp
                                    <tr>
                                        <td>{{ $section->programCourse->code }} — {{ $section->programCourse->name }}</td>
                                        <td>{{ $section->section_code }}</td>
                                        <td>{{ $section->instructor_name }}</td>
                                        @if($registrationOpen)
                                            <td class="text-end">
                                                <form method="POST" action="{{ route('student.registration.destroy', $enrollment) }}" onsubmit="return confirm('هل تريد إسقاط هذا المقرر؟')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">إسقاط</button>
                                                </form>
                                            </td>
                                        @endif
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif

        <div class="card custom-card">
            <div class="card-header">
                <h6 class="mb-0 fw-semibold">الشعب المتاحة للتسجيل</h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>المقرر</th>
                                <th>الشعبة</th>
                                <th>المدرس</th>
                                <th>الأيام</th>
                                <th>الوقت</th>
                                <th>المقاعد</th>
                                @if($registrationOpen)
                                    <th></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($availableSections as $section)
                                <tr>
                                    <td>{{ $section->programCourse->code }} — {{ $section->programCourse->name }}</td>
                                    <td>{{ $section->section_code }}</td>
                                    <td>{{ $section->instructor_name }}</td>
                                    <td>{{ $section->days_label }}</td>
                                    <td>{{ $section->time_range }}</td>
                                    <td>{{ $section->enrolledCount() }}/{{ $section->capacity }}</td>
                                    @if($registrationOpen)
                                        <td class="text-end">
                                            <form method="POST" action="{{ route('student.registration.store') }}">
                                                @csrf
                                                <input type="hidden" name="course_section_id" value="{{ $section->id }}">
                                                <button type="submit" class="btn btn-sm btn-primary">تسجيل</button>
                                            </form>
                                        </td>
                                    @endif
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="{{ $registrationOpen ? 7 : 6 }}" class="text-center text-muted py-4">
                                        @if(!$registrationOpen)
                                            التسجيل غير متاح حالياً.
                                        @else
                                            لا توجد شعب متاحة.
                                        @endif
                                    </td>
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
