@php
    $isEdit = isset($program) && $program?->exists;
    $isActive = (bool) old('is_active', $isEdit ? $program->is_active : true);
    $levelLabel = $isEdit
        ? ($program->level_label ?: '—')
        : (collect($levels)->first(fn ($l) => $l->value === old('level', 'bachelor'))?->label() ?? 'بكالوريوس');
    $collegeName = $isEdit
        ? ($program->college?->name ?? '—')
        : ($colleges->firstWhere('id', old('college_id', $selectedCollegeId ?? null))?->name ?? 'اختر الكلية');
    $departmentName = $isEdit
        ? ($program->department?->name ?? 'بدون قسم')
        : ($departments->firstWhere('id', old('department_id', $selectedDepartmentId ?? null))?->name ?? 'بدون قسم');
@endphp

<div class="sidebar-sticky">
    <div class="card custom-card form-card mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-semibold fs-15"><i class="ri-graduation-cap-line me-1 text-primary"></i> معاينة البرنامج</h6>
        </div>
        <div class="card-body text-center">
            <div class="entity-form-icon-hero" id="programIconHero">
                <i class="ri-graduation-cap-line"></i>
            </div>
            <span class="badge bg-primary-transparent text-primary mt-3" id="programLevelPreview">{{ $levelLabel }}</span>
            <p class="fw-semibold fs-14 mb-1 mt-3" id="programNamePreview">
                {{ old('name', $isEdit ? $program->name : 'اسم البرنامج') }}
            </p>
            <p class="text-muted fs-12 mb-0" id="programCollegePreview">{{ $collegeName }}</p>
            <p class="text-muted fs-12 mb-0" id="programDepartmentPreview">{{ $departmentName }}</p>
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
                    <label class="form-check-label fw-semibold" for="is_active">برنامج نشط</label>
                </div>
                <p class="text-muted fs-12 mb-0 mt-2">عند التفعيل يظهر البرنامج في الموقع وصفحات القبول.</p>
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
                    <span class="entity-form-stat-item__icon bg-purple-transparent text-purple"><i class="ri-time-line"></i></span>
                    <div>
                        <span class="entity-form-stat-item__value" id="programDurationPreview">{{ $program->duration ?: '—' }}</span>
                        <span class="entity-form-stat-item__label">المدة</span>
                    </div>
                </div>
                <div class="entity-form-stat-item">
                    <span class="entity-form-stat-item__icon bg-cyan-transparent text-cyan"><i class="ri-book-open-line"></i></span>
                    <div>
                        <span class="entity-form-stat-item__value" id="programCreditsPreview">{{ $program->credits ? number_format($program->credits) : '—' }}</span>
                        <span class="entity-form-stat-item__label">ساعة معتمدة</span>
                    </div>
                </div>
                <div class="entity-form-stat-item">
                    <span class="entity-form-stat-item__icon bg-success-transparent text-success"><i class="ri-list-check-2"></i></span>
                    <div>
                        <span class="entity-form-stat-item__value">{{ number_format($program->courses_count) }}</span>
                        <span class="entity-form-stat-item__label">مقرر</span>
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
            <a href="{{ route('admin.academic.programs.show', $program) }}" class="btn btn-light border btn-sm">
                <i class="ri-eye-line me-1"></i> عرض في لوحة التحكم
            </a>
            <a href="{{ route('programs.show', $program->slug) }}" class="btn btn-light border btn-sm" target="_blank" rel="noopener">
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
                    <p class="text-muted fs-12 mb-0">أكمل الوصف ومتطلبات القبول بمحتوى غني — يظهر في صفحة البرنامج على الموقع.</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="card custom-card form-card sidebar-submit-card">
        <div class="card-body">
            <button type="submit" class="btn btn-primary w-100 mb-2 btn-wave">
                <i class="ri-save-line me-1"></i> {{ $isEdit ? 'حفظ التعديلات' : 'إنشاء البرنامج' }}
            </button>
            <a href="{{ route('admin.academic.programs.index') }}" class="btn btn-light border w-100">
                <i class="ri-close-line me-1"></i> إلغاء
            </a>
        </div>
    </div>
</div>
