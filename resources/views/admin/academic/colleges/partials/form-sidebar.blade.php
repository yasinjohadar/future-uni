@php
    $isEdit = isset($college) && $college?->exists;
    $iconRaw = old('icon', $isEdit ? ($college->icon ?? '') : '');
    $iconClass = trim((string) ($iconRaw ?: 'ri-building-line'));
    if ($iconClass && ! str_contains($iconClass, ' ') && str_starts_with($iconClass, 'fa-')) {
        $iconClass = 'fas ' . $iconClass;
    }
    $isActive = (bool) old('is_active', $isEdit ? $college->is_active : true);
@endphp

<div class="sidebar-sticky">
    <div class="card custom-card form-card mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-semibold fs-15"><i class="ri-palette-line me-1 text-primary"></i> معاينة الأيقونة</h6>
        </div>
        <div class="card-body text-center">
            <div class="entity-form-icon-hero" id="collegeIconHero">
                <i class="{{ $iconClass }}"></i>
            </div>
            <p class="text-muted fs-12 mb-0 mt-3" id="collegeNamePreview">
                {{ old('name', $isEdit ? $college->name : 'اسم الكلية') }}
            </p>
        </div>
    </div>

    <div class="card custom-card form-card mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-semibold fs-15"><i class="ri-shield-check-line me-1 text-primary"></i> حالة النشر</h6>
        </div>
        <div class="card-body">
            <input type="hidden" name="is_active" value="0">
            <div class="account-switch-panel">
                <div class="form-check form-switch mb-0">
                    <input class="form-check-input" type="checkbox" name="is_active" value="1"
                           id="is_active" @checked($isActive)>
                    <label class="form-check-label fw-semibold" for="is_active">كلية نشطة</label>
                </div>
                <p class="text-muted fs-12 mb-0 mt-2">عند التفعيل تظهر الكلية في الموقع والقوائم العامة.</p>
            </div>
        </div>
    </div>

    @if($isEdit)
    <div class="card custom-card form-card mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-semibold fs-15"><i class="ri-pie-chart-line me-1 text-primary"></i> إحصائيات سريعة</h6>
        </div>
        <div class="card-body p-0">
            <div class="entity-form-stat-list">
                <div class="entity-form-stat-item">
                    <span class="entity-form-stat-item__icon bg-purple-transparent text-purple"><i class="ri-organization-chart"></i></span>
                    <div>
                        <span class="entity-form-stat-item__value">{{ number_format($college->departments_count) }}</span>
                        <span class="entity-form-stat-item__label">قسم</span>
                    </div>
                </div>
                <div class="entity-form-stat-item">
                    <span class="entity-form-stat-item__icon bg-cyan-transparent text-cyan"><i class="ri-book-open-line"></i></span>
                    <div>
                        <span class="entity-form-stat-item__value">{{ number_format($college->programs_count) }}</span>
                        <span class="entity-form-stat-item__label">برنامج</span>
                    </div>
                </div>
                <div class="entity-form-stat-item">
                    <span class="entity-form-stat-item__icon bg-success-transparent text-success"><i class="ri-group-line"></i></span>
                    <div>
                        <span class="entity-form-stat-item__value">{{ number_format($college->staff_members_count) }}</span>
                        <span class="entity-form-stat-item__label">عضو هيئة</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card custom-card form-card mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-semibold fs-15"><i class="ri-links-line me-1 text-primary"></i> روابط سريعة</h6>
        </div>
        <div class="card-body d-grid gap-2">
            <a href="{{ route('admin.academic.colleges.show', $college) }}" class="btn btn-light border btn-sm">
                <i class="ri-eye-line me-1"></i> عرض في لوحة التحكم
            </a>
            <a href="{{ route('colleges.show', $college->slug) }}" class="btn btn-light border btn-sm" target="_blank" rel="noopener">
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
                    <p class="text-muted fs-12 mb-0">أكمل الوصف والرؤية والرسالة بمحتوى غني — يظهر في صفحة تفاصيل الكلية على الموقع.</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="card custom-card form-card sidebar-submit-card">
        <div class="card-body">
            <button type="submit" class="btn btn-primary w-100 mb-2 btn-wave">
                <i class="ri-save-line me-1"></i> {{ $isEdit ? 'حفظ التعديلات' : 'إنشاء الكلية' }}
            </button>
            <a href="{{ route('admin.academic.colleges.index') }}" class="btn btn-light border w-100">
                <i class="ri-close-line me-1"></i> إلغاء
            </a>
        </div>
    </div>
</div>
