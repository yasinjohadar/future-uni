@php
    $iconClass = $staff->icon
        ? (str_contains($staff->icon, ' ') ? $staff->icon : 'fas ' . $staff->icon)
        : 'fas fa-user-tie';
    $stats = $staff->stats ?? [];
@endphp

<aside class="entity-show-sidebar">
    <div class="entity-show-panel">
        <div class="entity-show-panel__head">
            <span class="entity-show-panel__icon"><i class="{{ $iconClass }}"></i></span>
            <div>
                <h6 class="entity-show-panel__title mb-1">{{ $staff->name }}</h6>
                <p class="entity-show-panel__slug mb-0" dir="ltr">{{ $staff->slug }}</p>
            </div>
        </div>
        <div class="entity-show-panel__badges">
            <span class="badge bg-primary-transparent">{{ $staff->type?->label() }}</span>
            @if($staff->is_active)
                <span class="badge bg-success-transparent">نشط</span>
            @else
                <span class="badge bg-secondary-transparent">غير نشط</span>
            @endif
            @if($staff->is_featured)
                <span class="badge badge-soft-warning">مميز</span>
            @endif
        </div>
        @if($staff->position)
            <p class="text-muted fs-13 mb-0 mt-3">{{ $staff->position }}</p>
        @endif
        @if($staff->academic_title)
            <p class="text-muted fs-12 mb-0 mt-1">{{ $staff->academic_title }}</p>
        @endif
    </div>

    <div class="entity-show-panel">
        <h6 class="entity-show-panel__label"><i class="ri-contacts-line ms-1"></i> التواصل</h6>
        @if($staff->email)
        <div class="entity-show-info-row">
            <span>البريد</span>
            <strong dir="ltr" class="fs-12">{{ $staff->email }}</strong>
        </div>
        @endif
        @if($staff->phone)
        <div class="entity-show-info-row">
            <span>الهاتف</span>
            <strong dir="ltr">{{ $staff->phone }}</strong>
        </div>
        @endif
        @if($staff->office)
        <div class="entity-show-info-row">
            <span>المكتب</span>
            <strong>{{ $staff->office }}</strong>
        </div>
        @endif
        @if(! $staff->email && ! $staff->phone && ! $staff->office)
            <p class="text-muted fs-13 mb-0">لا توجد بيانات تواصل.</p>
        @endif
    </div>

    <div class="entity-show-panel">
        <h6 class="entity-show-panel__label"><i class="ri-building-2-line ms-1"></i> الانتماء</h6>
        <div class="entity-show-info-row">
            <span>الكلية</span>
            <strong>{{ $staff->college?->name ?: '—' }}</strong>
        </div>
        <div class="entity-show-info-row">
            <span>القسم</span>
            <strong>{{ $staff->department?->name ?: '—' }}</strong>
        </div>
        <div class="entity-show-info-row">
            <span>البرنامج</span>
            <strong>{{ $staff->program?->name ?: '—' }}</strong>
        </div>
        <div class="entity-show-info-row">
            <span>التخصص</span>
            <strong>{{ $staff->specialty ?: '—' }}</strong>
        </div>
        <div class="entity-show-info-row">
            <span>الترتيب</span>
            <strong dir="ltr">{{ $staff->sort_order }}</strong>
        </div>
    </div>

    <div class="entity-show-panel">
        <h6 class="entity-show-panel__label"><i class="ri-links-line ms-1"></i> روابط سريعة</h6>
        <div class="d-grid gap-2">
            <a href="{{ route('staff.show', $staff->slug) }}" class="btn btn-light btn-sm text-start" target="_blank" rel="noopener">
                <i class="ri-external-link-line ms-1"></i> معاينة في الموقع
            </a>
            <a href="{{ route('admin.people.staff.edit', $staff) }}" class="btn btn-light btn-sm text-start">
                <i class="ri-pencil-line ms-1"></i> تعديل البيانات
            </a>
            @if($staff->college)
            <a href="{{ route('admin.academic.colleges.show', $staff->college) }}" class="btn btn-light btn-sm text-start">
                <i class="ri-building-2-line ms-1"></i> صفحة الكلية
            </a>
            @endif
            @if($staff->department)
            <a href="{{ route('admin.academic.departments.show', $staff->department) }}" class="btn btn-light btn-sm text-start">
                <i class="ri-node-tree ms-1"></i> صفحة القسم
            </a>
            @endif
            <a href="{{ route('admin.people.staff.index', array_filter(['type' => $staff->type?->value, 'college_id' => $staff->college_id])) }}" class="btn btn-light btn-sm text-start">
                <i class="ri-team-line ms-1"></i> قائمة الهيئة
            </a>
        </div>
    </div>
</aside>
