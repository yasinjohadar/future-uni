@extends('admin.layouts.master')

@section('page-title') {{ $program->name }} @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'البرامج', 'url' => route('admin.academic.programs.index')],
                ['label' => $program->name],
            ],
            'title' => $program->name,
            'subtitle' => $program->slug,
            'actions' => '
                <a href="' . route('programs.show', $program->slug) . '" class="btn btn-light border btn-sm" target="_blank"><i class="ri-external-link-line"></i> معاينة</a>
                <a href="' . route('admin.academic.programs.edit', $program) . '" class="btn btn-primary btn-sm"><i class="ri-pencil-line"></i> تعديل</a>
            ',
        ])

        <div class="row g-3 mb-4">
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-award-line', 'label' => 'المستوى', 'value' => $program->level_label, 'hint' => 'درجة علمية'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'cyan', 'icon' => 'ri-time-line', 'label' => 'المدة', 'value' => $program->duration ?: '—', 'hint' => 'مدة الدراسة'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-bookmark-line', 'label' => 'ساعات معتمدة', 'value' => $program->credits ? number_format($program->credits) : '—', 'hint' => 'credit hours'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'orange', 'icon' => 'ri-checkbox-circle-line', 'label' => 'الحالة', 'value' => $program->is_active ? 'نشط' : 'غير نشط', 'hint' => $program->is_active ? 'ظاهر في الموقع' : 'مخفي'])
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-file-text-line ms-1"></i> عن البرنامج</h6>
                    @if($program->description)
                        <div class="admin-rich-content">{!! $program->description !!}</div>
                    @else
                        <p class="text-muted mb-0">لا يوجد وصف.</p>
                    @endif
                </div>

                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-list-check-2 ms-1"></i> متطلبات القبول</h6>
                    @if($program->requirements)
                        <div class="admin-rich-content">{!! $program->requirements !!}</div>
                    @else
                        <p class="text-muted mb-0">لا توجد متطلبات محددة.</p>
                    @endif
                </div>

                @if(!empty($program->objectives))
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-focus-2-line ms-1"></i> أهداف البرنامج</h6>
                    <ul class="mb-0 ps-3">
                        @foreach($program->objectives as $objective)
                            <li class="mb-1">{{ is_array($objective) ? ($objective['text'] ?? '') : $objective }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(!empty($program->careers))
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-briefcase-line ms-1"></i> فرص العمل</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($program->careers as $career)
                            <span class="badge-soft badge-soft-info">{{ is_array($career) ? ($career['title'] ?? '') : $career }}</span>
                        @endforeach
                    </div>
                </div>
                @endif

                @if($program->courses->isNotEmpty())
                <div class="entity-show-panel mb-0">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="entity-show-panel__label mb-0"><i class="ri-book-2-line ms-1"></i> المقررات ({{ $program->courses->count() }})</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table data-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>المقرر</th>
                                    <th>الترتيب</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($program->courses as $course)
                                <tr>
                                    <td class="text-muted fw-medium">{{ $loop->iteration }}</td>
                                    <td>{{ $course->name ?? $course->title ?? '—' }}</td>
                                    <td dir="ltr">{{ $course->sort_order }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                @include('admin.academic.programs.partials.show-sidebar')
            </div>
        </div>
    </div>
</div>
@endsection
