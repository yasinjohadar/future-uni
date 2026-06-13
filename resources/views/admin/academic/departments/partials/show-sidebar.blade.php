@php
    $programsCount = $department->programs->count();
@endphp

<aside class="entity-show-sidebar">
    <div class="entity-show-panel">
        <div class="entity-show-panel__head">
            <span class="entity-show-panel__icon"><i class="fas {{ $department->icon ?? 'fa-layer-group' }}"></i></span>
            <div>
                <h6 class="entity-show-panel__title mb-1">{{ $department->name }}</h6>
                <p class="entity-show-panel__slug mb-0" dir="ltr">{{ $department->slug }}</p>
            </div>
        </div>
        <div class="entity-show-panel__badges">
            @if($department->is_active)
                <span class="badge bg-success-transparent">نشط</span>
            @else
                <span class="badge bg-secondary-transparent">غير نشط</span>
            @endif
            @if($department->college)
                <span class="badge bg-primary-transparent">{{ $department->college->name }}</span>
            @endif
        </div>
    </div>

    <div class="entity-show-panel">
        <h6 class="entity-show-panel__label"><i class="ri-information-line ms-1"></i> معلومات القسم</h6>
        @if($department->college)
        <div class="entity-show-info-row">
            <span>الكلية</span>
            <strong>{{ $department->college->name }}</strong>
        </div>
        @endif
        <div class="entity-show-info-row">
            <span>البرامج</span>
            <strong dir="ltr">{{ $programsCount }}</strong>
        </div>
        <div class="entity-show-info-row">
            <span>هيئة التدريس</span>
            <strong dir="ltr">{{ $department->faculty_count ?: ($staffCount ?? 0) }}</strong>
        </div>
        <div class="entity-show-info-row">
            <span>الترتيب</span>
            <strong dir="ltr">{{ $department->sort_order }}</strong>
        </div>
    </div>

    <div class="entity-show-panel">
        <h6 class="entity-show-panel__label"><i class="ri-links-line ms-1"></i> روابط سريعة</h6>
        <div class="d-grid gap-2">
            @if($department->college)
            <a href="{{ route('departments.show', [$department->college->slug, $department->slug]) }}" class="btn btn-light btn-sm text-start" target="_blank">
                <i class="ri-external-link-line ms-1"></i> معاينة في الموقع
            </a>
            <a href="{{ route('admin.academic.colleges.show', $department->college) }}" class="btn btn-light btn-sm text-start">
                <i class="ri-building-2-line ms-1"></i> صفحة الكلية
            </a>
            @endif
            <a href="{{ route('admin.academic.programs.index', ['college_id' => $department->college_id, 'department_id' => $department->id]) }}" class="btn btn-light btn-sm text-start">
                <i class="ri-book-open-line ms-1"></i> إدارة البرامج
            </a>
            <a href="{{ route('admin.academic.departments.index', ['college_id' => $department->college_id]) }}" class="btn btn-light btn-sm text-start">
                <i class="ri-node-tree ms-1"></i> كل أقسام الكلية
            </a>
            <a href="{{ route('admin.people.staff.index', ['department_id' => $department->id]) }}" class="btn btn-light btn-sm text-start">
                <i class="ri-group-line ms-1"></i> أعضاء الهيئة
            </a>
        </div>
    </div>
</aside>
