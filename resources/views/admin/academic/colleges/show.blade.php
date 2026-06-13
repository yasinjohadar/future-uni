@extends('admin.layouts.master')

@section('page-title') {{ $college->name }} @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')
        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'الكليات', 'url' => route('admin.academic.colleges.index')],
                ['label' => $college->name],
            ],
            'title' => $college->name,
            'subtitle' => $college->slug,
            'actions' => '
                <a href="' . route('colleges.show', $college->slug) . '" class="btn btn-light border btn-sm" target="_blank"><i class="ri-external-link-line"></i> معاينة</a>
                <a href="' . route('admin.academic.colleges.edit', $college) . '" class="btn btn-primary btn-sm"><i class="ri-pencil-line"></i> تعديل</a>
            ',
        ])

        <div class="row g-3 mb-4">
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-organization-chart', 'label' => 'الأقسام', 'value' => number_format($college->departments_count), 'hint' => 'قسم أكاديمي'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'cyan', 'icon' => 'ri-book-open-line', 'label' => 'البرامج', 'value' => number_format($college->programs_count), 'hint' => 'برنامج دراسي'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-group-line', 'label' => 'أعضاء الهيئة', 'value' => number_format($college->staff_members_count), 'hint' => 'عضو هيئة'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'orange', 'icon' => 'ri-checkbox-circle-line', 'label' => 'الحالة', 'value' => $college->is_active ? 'نشط' : 'غير نشط', 'hint' => $college->is_active ? 'ظاهرة في الموقع' : 'مخفية'])
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-file-text-line ms-1"></i> عن الكلية</h6>
                    @if($college->description)
                        <div class="admin-rich-content">{!! $college->description !!}</div>
                    @else
                        <p class="text-muted mb-0">لا يوجد وصف.</p>
                    @endif
                </div>

                @if($college->vision)
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-eye-line ms-1"></i> الرؤية</h6>
                    <div class="admin-rich-content">{!! $college->vision !!}</div>
                </div>
                @endif

                @if($college->mission)
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-focus-3-line ms-1"></i> الرسالة</h6>
                    <div class="admin-rich-content">{!! $college->mission !!}</div>
                </div>
                @endif

                @if($college->departments->isNotEmpty())
                <div class="entity-show-panel mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="entity-show-panel__label mb-0"><i class="ri-organization-chart ms-1"></i> الأقسام الأكاديمية</h6>
                        <a href="{{ route('admin.academic.departments.index', ['college_id' => $college->id]) }}" class="btn btn-link btn-sm p-0">عرض الكل</a>
                    </div>
                    <div class="row g-3">
                        @foreach($college->departments as $department)
                        <div class="col-md-6">
                            <a href="{{ route('admin.academic.departments.show', $department) }}" class="entity-show-link-card text-decoration-none">
                                <div class="entity-show-link-card__icon"><i class="fas {{ $department->icon ?? 'fa-layer-group' }}"></i></div>
                                <div class="entity-show-link-card__body">
                                    <h6 class="entity-show-link-card__title">{{ $department->name }}</h6>
                                    <p class="entity-show-link-card__meta mb-0">
                                        <span><i class="ri-book-open-line"></i> {{ $department->programs_count }} برامج</span>
                                        <span><i class="ri-group-line"></i> {{ $department->faculty_count }} عضو</span>
                                    </p>
                                </div>
                                @if($department->is_active)
                                    <span class="badge bg-success-transparent">نشط</span>
                                @else
                                    <span class="badge bg-secondary-transparent">غير نشط</span>
                                @endif
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($college->programs->isNotEmpty())
                <div class="entity-show-panel mb-0">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="entity-show-panel__label mb-0"><i class="ri-book-open-line ms-1"></i> البرامج الأكابيمية</h6>
                        <a href="{{ route('admin.academic.programs.index', ['college_id' => $college->id]) }}" class="btn btn-link btn-sm p-0">عرض الكل</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table data-table mb-0">
                            <thead>
                                <tr>
                                    <th>البرنامج</th>
                                    <th>المستوى</th>
                                    <th>المدة</th>
                                    <th>الحالة</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($college->programs as $program)
                                <tr>
                                    <td>
                                        <a href="{{ route('admin.academic.programs.show', $program) }}" class="fw-semibold text-decoration-none">{{ $program->name }}</a>
                                    </td>
                                    <td>{{ $program->level_label }}</td>
                                    <td>{{ $program->duration ?: '—' }}</td>
                                    <td>
                                        @if($program->is_active)
                                            <span class="badge bg-success-transparent">نشط</span>
                                        @else
                                            <span class="badge bg-secondary-transparent">غير نشط</span>
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.academic.programs.edit', $program) }}" class="btn btn-sm btn-light"><i class="ri-pencil-line"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                @include('admin.academic.colleges.partials.show-sidebar')
            </div>
        </div>
    </div>
</div>
@endsection
