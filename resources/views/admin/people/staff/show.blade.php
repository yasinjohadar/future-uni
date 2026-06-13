@extends('admin.layouts.master')

@section('page-title') {{ $staff->name }} @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')

        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'أعضاء الهيئة', 'url' => route('admin.people.staff.index')],
                ['label' => $staff->name],
            ],
            'title' => $staff->name,
            'subtitle' => trim(collect([$staff->type?->label(), $staff->position])->filter()->implode(' · ')),
            'actions' => '
                <a href="' . route('staff.show', $staff->slug) . '" class="btn btn-light border btn-sm" target="_blank" rel="noopener"><i class="ri-external-link-line"></i> معاينة</a>
                <a href="' . route('admin.people.staff.edit', $staff) . '" class="btn btn-primary btn-sm"><i class="ri-pencil-line"></i> تعديل</a>
            ',
        ])

        @php $stats = $staff->stats ?? []; @endphp

        <div class="row g-3 mb-4">
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-article-line', 'label' => 'منشورات', 'value' => isset($stats['publications']) ? number_format($stats['publications']) : '—', 'hint' => 'منشورات علمية'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'cyan', 'icon' => 'ri-quote-text', 'label' => 'استشهادات', 'value' => isset($stats['citations']) ? number_format($stats['citations']) : '—', 'hint' => 'citations'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-bar-chart-box-line', 'label' => 'h-index', 'value' => $stats['hIndex'] ?? '—', 'hint' => 'مؤشر h'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'orange', 'icon' => 'ri-time-line', 'label' => 'الخبرة', 'value' => isset($stats['experience']) ? number_format($stats['experience']) . ' سنة' : '—', 'hint' => 'سنوات خبرة'])
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-file-text-line ms-1"></i> النبذة التعريفية</h6>
                    @if($staff->bio)
                        <div class="admin-rich-content">{!! $staff->bio !!}</div>
                    @else
                        <p class="text-muted mb-0">لا توجد نبذة تعريفية.</p>
                    @endif
                </div>

                @if(! empty($staff->education))
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-graduation-cap-line ms-1"></i> المؤهلات العلمية</h6>
                    <div class="staff-timeline">
                        @foreach($staff->education as $item)
                        <div class="staff-timeline__item">
                            <span class="staff-timeline__year">{{ $item['year'] ?? '—' }}</span>
                            <div>
                                <strong class="d-block">{{ $item['degree'] ?? '—' }}</strong>
                                <span class="text-muted fs-13">{{ $item['institution'] ?? '' }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(! empty($staff->experience_history))
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-briefcase-line ms-1"></i> الخبرات المهنية</h6>
                    <div class="staff-timeline">
                        @foreach($staff->experience_history as $item)
                        <div class="staff-timeline__item">
                            <span class="staff-timeline__year">{{ $item['year'] ?? '—' }}</span>
                            <div>
                                <strong class="d-block">{{ $item['role'] ?? '—' }}</strong>
                                @if(! empty($item['desc']))
                                    <span class="text-muted fs-13">{{ $item['desc'] }}</span>
                                @endif
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                @if(! empty($staff->publications))
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-book-open-line ms-1"></i> المنشورات</h6>
                    <div class="table-responsive">
                        <table class="table data-table mb-0">
                            <thead>
                                <tr>
                                    <th>العنوان</th>
                                    <th>المجلة</th>
                                    <th>السنة</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($staff->publications as $pub)
                                <tr>
                                    <td class="fw-semibold">{{ $pub['title'] ?? '—' }}</td>
                                    <td>{{ $pub['journal'] ?? '—' }}</td>
                                    <td dir="ltr">{{ $pub['year'] ?? '—' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                @endif

                @if(! empty($staff->awards))
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-award-line ms-1"></i> الجوائز والتكريمات</h6>
                    <ul class="staff-awards-list mb-0">
                        @foreach($staff->awards as $award)
                            <li><i class="ri-medal-line text-warning"></i> {{ is_array($award) ? ($award['title'] ?? json_encode($award)) : $award }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                @if(! empty($staff->skills))
                <div class="entity-show-panel mb-0">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-tools-line ms-1"></i> المهارات</h6>
                    <div class="row g-3">
                        @foreach($staff->skills as $skill)
                        <div class="col-md-6">
                            <div class="staff-skill-item">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="fw-semibold fs-13">{{ $skill['name'] ?? '—' }}</span>
                                    <span class="text-muted fs-12">{{ $skill['level'] ?? 0 }}%</span>
                                </div>
                                <div class="progress progress-sm">
                                    <div class="progress-bar bg-primary" style="width: {{ min(100, (int) ($skill['level'] ?? 0)) }}%"></div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                @include('admin.people.staff.partials.show-sidebar')
            </div>
        </div>
    </div>
</div>
@endsection
