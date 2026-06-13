@extends('admin.layouts.master')

@section('page-title') {{ $center->name }} @stop

@section('content')
<div class="main-content app-content">
    <div class="container-fluid">
        @include('admin.partials.ui.alerts')
        @include('admin.partials.ui.page-header', [
            'breadcrumbs' => [
                ['label' => 'لوحة التحكم', 'url' => route('admin.dashboard')],
                ['label' => 'مراكز البحث', 'url' => route('admin.research.centers.index')],
                ['label' => $center->name],
            ],
            'title' => $center->name,
            'subtitle' => $center->slug,
            'actions' => '
                <a href="' . route('research.show', $center->slug) . '" class="btn btn-light border btn-sm" target="_blank"><i class="ri-external-link-line"></i> معاينة</a>
                <a href="' . route('admin.research.centers.edit', $center) . '" class="btn btn-primary btn-sm"><i class="ri-pencil-line"></i> تعديل</a>
            ',
        ])

        <div class="row g-3 mb-4">
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'purple', 'icon' => 'ri-folder-open-line', 'label' => 'المشاريع', 'value' => number_format($center->projects_count), 'hint' => 'مشروع بحثي'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'cyan', 'icon' => 'ri-file-text-line', 'label' => 'المنشورات', 'value' => number_format($center->publications_count), 'hint' => 'منشور علمي'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'green', 'icon' => 'ri-team-line', 'label' => 'الباحثون', 'value' => number_format($center->statValue('researchers', 0)), 'hint' => 'عضو بحثي'])
            @include('admin.partials.ui.stat-card-gradient', ['variant' => 'orange', 'icon' => 'ri-checkbox-circle-line', 'label' => 'الحالة', 'value' => $center->is_active ? 'نشط' : 'غير نشط', 'hint' => $center->is_active ? 'ظاهر في الموقع' : 'مخفي'])
        </div>

        <div class="row g-4">
            <div class="col-lg-8">
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-file-text-line ms-1"></i> الوصف المختصر</h6>
                    <p class="text-secondary mb-0">{{ $center->description ?: '—' }}</p>
                </div>
                @if($center->long_description)
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-article-line ms-1"></i> المحتوى التفصيلي</h6>
                    <div class="admin-rich-content">{!! $center->long_description !!}</div>
                </div>
                @endif
                @if(! empty($center->focus_areas))
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-focus-3-line ms-1"></i> مجالات التركيز</h6>
                    <div class="d-flex flex-wrap gap-2">
                        @foreach($center->focus_areas as $area)
                            <span class="badge-soft badge-soft-primary">{{ $area }}</span>
                        @endforeach
                    </div>
                </div>
                @endif
                @if(! empty($center->active_projects))
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-flask-line ms-1"></i> المشاريع النشطة</h6>
                    <ul class="list-unstyled mb-0">
                        @foreach($center->active_projects as $project)
                            <li class="mb-2"><strong>{{ $project['title'] ?? '' }}</strong> — {{ $project['status'] ?? '' }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-information-line ms-1"></i> معلومات</h6>
                    <div class="entity-show-meta">
                        <div><span>الكلية</span><strong>{{ $center->collegeDisplayName() }}</strong></div>
                        <div><span>المدير</span><strong>{{ $center->directorDisplayName() }}</strong></div>
                        <div><span>التأسيس</span><strong>{{ $center->established ?? '—' }}</strong></div>
                        <div><span>البريد</span><strong dir="ltr">{{ $center->email ?? '—' }}</strong></div>
                        <div><span>الهاتف</span><strong dir="ltr">{{ $center->phone ?? '—' }}</strong></div>
                    </div>
                </div>
                @if(! empty($center->partners))
                <div class="entity-show-panel mb-4">
                    <h6 class="entity-show-panel__label mb-3"><i class="ri-handshake-line ms-1"></i> الشركاء</h6>
                    <ul class="mb-0 ps-3">@foreach($center->partners as $partner)<li>{{ $partner }}</li>@endforeach</ul>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
