@php
    $categoryLabels = [
        'engineering' => 'الهندسة والتقنية',
        'medical' => 'العلوم الطبية',
        'business' => 'الإدارة والإنسانية',
        'science' => 'العلوم الأساسية',
    ];
    $shortName = str_replace('كلية ', '', $college->name);
@endphp

<aside class="entity-show-sidebar">
    <div class="entity-show-panel">
        <div class="entity-show-panel__head">
            <span class="entity-show-panel__icon"><i class="fas {{ $college->icon ?? 'fa-building-columns' }}"></i></span>
            <div>
                <h6 class="entity-show-panel__title mb-1">{{ $college->name }}</h6>
                <p class="entity-show-panel__slug mb-0" dir="ltr">{{ $college->slug }}</p>
            </div>
        </div>
        <div class="entity-show-panel__badges">
            @if($college->is_active)
                <span class="badge bg-success-transparent">نشط</span>
            @else
                <span class="badge bg-secondary-transparent">غير نشط</span>
            @endif
            @if($college->accreditation)
                <span class="badge bg-primary-transparent">{{ $college->accreditation }}</span>
            @endif
        </div>
    </div>

    @if($college->dean)
    <div class="entity-show-panel">
        <h6 class="entity-show-panel__label"><i class="ri-user-star-line ms-1"></i> عميد الكلية</h6>
        <div class="entity-show-dean">
            <div class="entity-show-dean__avatar"><i class="ri-user-3-line"></i></div>
            <div>
                <div class="fw-semibold">{{ $college->dean->name }}</div>
                <div class="text-muted small">{{ $college->dean->position ?? 'عميد ' . $shortName }}</div>
            </div>
        </div>
        <a href="{{ route('admin.people.staff.edit', $college->dean) }}" class="btn btn-light btn-sm w-100 mt-3">تعديل العميد</a>
    </div>
    @endif

    <div class="entity-show-panel">
        <h6 class="entity-show-panel__label"><i class="ri-information-line ms-1"></i> معلومات الكلية</h6>
        @if($college->established)
        <div class="entity-show-info-row">
            <span>سنة التأسيس</span>
            <strong dir="ltr">{{ $college->established }}</strong>
        </div>
        @endif
        @if($college->students_count)
        <div class="entity-show-info-row">
            <span>الطلاب</span>
            <strong dir="ltr">{{ $college->students_count }}</strong>
        </div>
        @endif
        @if($college->building)
        <div class="entity-show-info-row">
            <span>المبنى</span>
            <strong>{{ $college->building }}</strong>
        </div>
        @endif
        @if($college->category)
        <div class="entity-show-info-row">
            <span>التصنيف</span>
            <strong>{{ $categoryLabels[$college->category] ?? $college->category }}</strong>
        </div>
        @endif
        <div class="entity-show-info-row">
            <span>الترتيب</span>
            <strong dir="ltr">{{ $college->sort_order }}</strong>
        </div>
    </div>

    <div class="entity-show-panel">
        <h6 class="entity-show-panel__label"><i class="ri-links-line ms-1"></i> روابط سريعة</h6>
        <div class="d-grid gap-2">
            <a href="{{ route('colleges.show', $college->slug) }}" class="btn btn-light btn-sm text-start" target="_blank">
                <i class="ri-external-link-line ms-1"></i> معاينة في الموقع
            </a>
            <a href="{{ route('admin.academic.departments.index', ['college_id' => $college->id]) }}" class="btn btn-light btn-sm text-start">
                <i class="ri-organization-chart ms-1"></i> إدارة الأقسام
            </a>
            <a href="{{ route('admin.academic.programs.index', ['college_id' => $college->id]) }}" class="btn btn-light btn-sm text-start">
                <i class="ri-book-open-line ms-1"></i> إدارة البرامج
            </a>
            <a href="{{ route('admin.people.staff.index', ['college_id' => $college->id]) }}" class="btn btn-light btn-sm text-start">
                <i class="ri-group-line ms-1"></i> أعضاء الهيئة
            </a>
        </div>
    </div>
</aside>
