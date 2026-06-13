@php
    $isEdit = isset($staff) && $staff?->exists;
    $iconRaw = old('icon', $isEdit ? ($staff->icon ?? '') : 'fa-user-tie');
    $iconClass = trim((string) ($iconRaw ?: 'ri-user-line'));
    if ($iconClass && ! str_contains($iconClass, ' ') && str_starts_with($iconClass, 'fa-')) {
        $iconClass = 'fas ' . $iconClass;
    }
    $isActive = (bool) old('is_active', $isEdit ? $staff->is_active : true);
    $isFeatured = (bool) old('is_featured', $isEdit ? $staff->is_featured : false);
    $typeLabel = collect($types)->first(fn ($t) => $t->value === old('type', $isEdit ? $staff->type?->value : ''))?->label() ?? 'عضو هيئة';
@endphp

<div class="sidebar-sticky">
    <div class="card custom-card form-card mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-semibold fs-15"><i class="ri-user-star-line me-1 text-primary"></i> معاينة العضو</h6>
        </div>
        <div class="card-body text-center">
            <div class="entity-form-icon-hero" id="staffIconHero">
                <i class="{{ $iconClass }}"></i>
            </div>
            <p class="fw-semibold fs-14 mb-1 mt-3" id="staffNamePreview">
                {{ old('name', $isEdit ? $staff->name : 'اسم العضو') }}
            </p>
            <p class="text-muted fs-12 mb-1" id="staffTypePreview">{{ $typeLabel }}</p>
            <p class="text-muted fs-12 mb-0" id="staffPositionPreview">
                {{ old('position', $isEdit ? ($staff->position ?: '—') : '—') }}
            </p>
        </div>
    </div>

    <div class="card custom-card form-card mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-semibold fs-15"><i class="ri-shield-check-line me-1 text-primary"></i> الإعدادات</h6>
        </div>
        <div class="card-body">
            <input type="hidden" name="is_active" value="0">
            <input type="hidden" name="is_featured" value="0">
            <div class="account-switch-panel mb-3">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                           id="is_active" @checked($isActive)>
                    <label class="form-check-label fw-semibold" for="is_active">عضو نشط</label>
                </div>
                <p class="text-muted fs-12 mb-0 mt-2">يظهر في قوائم الهيئة على الموقع.</p>
            </div>
            <div class="account-switch-panel">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" name="is_featured" value="1"
                           id="is_featured" @checked($isFeatured)>
                    <label class="form-check-label fw-semibold" for="is_featured">عضو مميز</label>
                </div>
                <p class="text-muted fs-12 mb-0 mt-2">يُعرض في الصفحة الرئيسية والأقسام البارزة.</p>
            </div>
        </div>
    </div>

    @if($isEdit)
    <div class="card custom-card form-card mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-semibold fs-15"><i class="ri-links-line me-1 text-primary"></i> روابط سريعة</h6>
        </div>
        <div class="card-body d-grid gap-2">
            <a href="{{ route('admin.people.staff.show', $staff) }}" class="btn btn-light border btn-sm">
                <i class="ri-eye-line me-1"></i> عرض في لوحة التحكم
            </a>
            <a href="{{ route('staff.show', $staff->slug) }}" class="btn btn-light border btn-sm" target="_blank" rel="noopener">
                <i class="ri-external-link-line me-1"></i> معاينة الموقع
            </a>
        </div>
    </div>
    @else
    <div class="card custom-card form-card mb-4">
        <div class="card-body">
            <div class="form-hint-banner border-0 mb-0">
                <span class="form-hint-banner__icon"><i class="ri-lightbulb-line"></i></span>
                <div>
                    <p class="fw-semibold mb-1 fs-13">نصيحة</p>
                    <p class="text-muted fs-12 mb-0">أكمل النبذة التعريفية بمحتوى غني — تظهر في صفحة العضو على الموقع.</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="card custom-card form-card sidebar-submit-card">
        <div class="card-body">
            <button type="submit" class="btn btn-primary w-100 mb-2 btn-wave">
                <i class="ri-save-line me-1"></i> {{ $isEdit ? 'حفظ التعديلات' : 'إنشاء العضو' }}
            </button>
            <a href="{{ route('admin.people.staff.index') }}" class="btn btn-light border w-100">
                <i class="ri-close-line me-1"></i> إلغاء
            </a>
        </div>
    </div>
</div>
