@php
    $isEdit = isset($center) && $center?->exists;
    $value = fn (string $key, mixed $default = '') => old($key, $isEdit ? ($center->{$key} ?? $default) : $default);
    $iconRaw = old('icon', $isEdit ? ($center->icon ?? '') : '');
    $iconClass = college_fa_icon($iconRaw, 'fa-flask');
    $focusAreasText = old('focus_areas_text', $isEdit ? implode("\n", $center->focus_areas ?? []) : '');
    $partnersText = old('partners_text', $isEdit ? implode("\n", $center->partners ?? []) : '');
    $projectsText = old('active_projects_text', $isEdit ? collect($center->active_projects ?? [])->map(fn ($p) => ($p['title'] ?? '') . '|' . ($p['status'] ?? ''))->implode("\n") : '');
@endphp

<div class="card custom-card form-card mb-4">
    <div class="card-header"><h6 class="mb-0 fw-semibold fs-15"><i class="ri-information-line me-1 text-primary"></i> المعلومات الأساسية</h6></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-semibold">اسم المركز <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control form-input-enhanced @error('name') is-invalid @enderror" value="{{ $value('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">الأيقونة</label>
                <div class="d-flex align-items-center gap-2">
                    <span class="icon-preview-box entity-form-icon-inline"><i class="{{ $iconClass }}"></i></span>
                    <input type="text" name="icon" class="form-control form-input-enhanced" value="{{ $iconRaw }}" placeholder="fa-robot" dir="ltr">
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">سنة التأسيس</label>
                <input type="text" name="established" class="form-control form-input-enhanced" value="{{ $value('established') }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">عدد المشاريع</label>
                <input type="number" name="projects_count" min="0" class="form-control form-input-enhanced" value="{{ $value('projects_count', 0) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">عدد المنشورات</label>
                <input type="number" name="publications_count" min="0" class="form-control form-input-enhanced" value="{{ $value('publications_count', 0) }}">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">الوصف المختصر</label>
                <textarea name="description" rows="3" class="form-control form-input-enhanced">{{ $value('description') }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="card custom-card form-card mb-4">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0 fw-semibold fs-15"><i class="ri-file-text-line me-1 text-primary"></i> المحتوى التفصيلي</h6>
        <span class="badge bg-primary-transparent text-primary">محرر غني</span>
    </div>
    <div class="card-body">
        <textarea id="long_description" name="long_description" rows="10" class="form-control">{{ $value('long_description') }}</textarea>
    </div>
</div>

<div class="card custom-card form-card mb-4">
    <div class="card-header"><h6 class="mb-0 fw-semibold fs-15"><i class="ri-focus-3-line me-1 text-primary"></i> مجالات ومشاريع وشركاء</h6></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">مجالات التركيز</label>
                <textarea name="focus_areas_text" rows="5" class="form-control form-input-enhanced" placeholder="سطر لكل مجال">{{ $focusAreasText }}</textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">المشاريع النشطة</label>
                <textarea name="active_projects_text" rows="5" class="form-control form-input-enhanced" placeholder="عنوان المشروع|الحالة">{{ $projectsText }}</textarea>
                <p class="text-muted fs-12 mb-0 mt-1">صيغة: عنوان|جاري أو مكتمل</p>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">الشركاء</label>
                <textarea name="partners_text" rows="5" class="form-control form-input-enhanced" placeholder="سطر لكل شريك">{{ $partnersText }}</textarea>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">عدد الباحثين</label>
                <input type="number" name="stats_researchers" min="0" class="form-control form-input-enhanced" value="{{ old('stats_researchers', $isEdit ? $center->statValue('researchers', 0) : 0) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">عدد المختبرات</label>
                <input type="number" name="stats_labs" min="0" class="form-control form-input-enhanced" value="{{ old('stats_labs', $isEdit ? $center->statValue('labs', 0) : 0) }}">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">المنح البحثية</label>
                <input type="number" name="stats_grants" min="0" class="form-control form-input-enhanced" value="{{ old('stats_grants', $isEdit ? $center->statValue('grants', 0) : 0) }}">
            </div>
        </div>
    </div>
</div>
