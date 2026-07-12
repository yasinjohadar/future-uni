@extends('doctor.layouts.master')

@section('page-title')
تسجيل الحضور
@stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        <div class="dashboard-welcome mb-4">
            <h4 class="dashboard-welcome__title mb-1">تسجيل الحضور — {{ $session->session_date?->format('Y-m-d') }}</h4>
            <p class="dashboard-welcome__subtitle mb-0">
                {{ $section->programCourse->code ?? '' }} — {{ $section->programCourse->name ?? '—' }}
                @if($session->title) · {{ $session->title }} @endif
            </p>
        </div>

        <form method="POST" action="{{ route('doctor.attendance.update', [$section, $session]) }}">
            @csrf
            @method('PUT')

            <div class="card custom-card">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th>الرقم الجامعي</th>
                                    <th>الاسم</th>
                                    <th>الحالة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($session->records as $record)
                                    <tr>
                                        <td>{{ $record->enrollment->student->student_number ?? '—' }}</td>
                                        <td>{{ $record->enrollment->student->user->name ?? '—' }}</td>
                                        <td>
                                            <select name="records[{{ $record->id }}][status]" class="form-select form-select-sm" style="max-width:160px">
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status->value }}" @selected(old("records.{$record->id}.status", $record->status?->value) === $status->value)>
                                                        {{ $status->label() }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer d-flex gap-2">
                    <button type="submit" class="btn btn-primary">حفظ الحضور</button>
                    <a href="{{ route('doctor.sections.show', $section) }}" class="btn btn-light border">رجوع</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
