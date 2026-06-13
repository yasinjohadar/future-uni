@extends('admin.layouts.master')

@section('page-title') {{ $department->name }} @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'الأقسام', 'url' => route('admin.academic.departments.index')],
                ['label' => $department->name],
            ],
            'title' => $department->name,
            'subtitle' => $department->college?->name,
            'actions' => '
                ' . ($department->college ? '<a href="' . route('departments.show', [$department->college->slug, $department->slug]) . '" class="btn btn-light border btn-sm" target="_blank"><i class="ri-external-link-line"></i> معاينة</a>' : '') . '
                <a href="' . route('admin.academic.departments.edit', $department) . '" class="btn btn-primary btn-sm"><i class="ri-pencil-line"></i> تعديل</a>
            ',
        ])

        <div class="row g-3 mb-4">
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-book-open-line', 'label' => 'البرامج', 'value' => number_format($department->programs->count()), 'hint' => 'برنامج دراسي'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-group-line', 'label' => 'هيئة التدريس', 'value' => number_format($department->faculty_count ?: $staffCount), 'hint' => 'عضو تدريس'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'cyan', 'icon' => 'ri-sort-number-asc', 'label' => 'الترتيب', 'value' => number_format($department->sort_order), 'hint' => 'ترتيب العرض'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'orange', 'icon' => 'ri-checkbox-circle-line', 'label' => 'الحالة', 'value' => $department->is_active ? 'نشط' : 'غير نشط', 'hint' => $department->is_active ? 'ظاهر في الموقع' : 'مخفي'])
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-file-text-line ms-1"></i> عن القسم</h6>
                    @if($department->description)
                        <div class="admin-rich-content">{!! $department->description !!}</div>
                    @else
                        <p class="text-muted mb-0">لا يوجد وصف.</p>
                    @endif
                </div>

                @if($department->programs->isNotEmpty())
                <div class="entity-show-panel mb-0">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="entity-show-panel__label mb-0"><i class="ri-book-open-line ms-1"></i> البرامج الأكاديمية</h6>
                        <a href="{{ route('admin.academic.programs.index', ['college_id' => $department->college_id, 'department_id' => $department->id]) }}" class="btn btn-link btn-sm p-0">عرض الكل</a>
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
                                @foreach($department->programs as $program)
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
                                        <div class="action-btn-group">
                                            <a href="{{ route('admin.academic.programs.show', $program) }}" class="action-btn action-btn--view" title="عرض">
                                                <i class="ri-eye-line"></i>
                                            </a>
                                            <a href="{{ route('admin.academic.programs.edit', $program) }}" class="action-btn action-btn--edit" title="تعديل">
                                                <i class="ri-pencil-line"></i>
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @else
                <div class="entity-show-panel mb-0">
                    <div class="empty-state py-4">
                        <div class="empty-state-icon"><i class="ri-book-open-line"></i></div>
                        <h5 class="fw-bold mb-2">لا توجد برامج</h5>
                        <p class="text-muted mb-3">لم يُربط أي برنامج بهذا القسم بعد.</p>
                        <a href="{{ route('admin.academic.programs.create', ['college_id' => $department->college_id, 'department_id' => $department->id]) }}" class="btn btn-primary btn-sm">
                            <i class="ri-add-line me-1"></i> إضافة برنامج
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                @include('admin.academic.departments.partials.show-sidebar')
            </div>
        </div>
    </div>
</div>
@endsection
