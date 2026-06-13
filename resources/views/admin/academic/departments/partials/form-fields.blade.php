@php
    $isEdit = isset($department) && $department?->exists;
    $value = fn (string $key, mixed $default = '') => old($key, $isEdit ? ($department->{$key} ?? $default) : $default);
    $selectedCollegeId = old('college_id', $isEdit ? $department->college_id : ($selectedCollegeId ?? null));
    $iconRaw = old('icon', $isEdit ? ($department->icon ?? '') : '');
    $iconClass = trim((string) ($iconRaw ?: 'ri-node-tree'));
    if ($iconClass && ! str_contains($iconClass, ' ') && str_starts_with($iconClass, 'fa-')) {
        $iconClass = 'fas ' . $iconClass;
    }
@endphp

<div class="card custom-card form-card mb-4">
    <div class="card-header">
        <h6 class="mb-0 fw-semibold fs-15"><i class="ri-information-line me-1 text-primary"></i> المعلومات الأساسية</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">الكلية <span class="text-danger">*</span></label>
                <select name="college_id" id="departmentCollege"
                        class="form-select form-input-enhanced @error('college_id') is-invalid @enderror" required>
                    <option value="">اختر الكلية</option>
                    @foreach($colleges as $collegeOption)
                        <option value="{{ $collegeOption->id }}" @selected($selectedCollegeId == $collegeOption->id)>
                            {{ $collegeOption->name }}
                        </option>
                    @endforeach
                </select>
                @error('college_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">اسم القسم <span class="text-danger">*</span></label>
                <input type="text" name="name" id="departmentName"
                       class="form-control form-input-enhanced @error('name') is-invalid @enderror"
                       value="{{ $value('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">الأيقونة</label>
                <div class="d-flex align-items-center gap-2">
                    <span class="icon-preview-box entity-form-icon-inline" id="departmentIconPreview">
                        <i class="{{ $iconClass }}"></i>
                    </span>
                    <input type="text" name="icon" id="departmentIcon"
                           class="form-control form-input-enhanced @error('icon') is-invalid @enderror"
                           value="{{ $iconRaw }}" placeholder="ri-node-tree أو fa-sitemap" dir="ltr">
                </div>
                @error('icon')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <p class="text-muted fs-12 mb-0 mt-1">Remix Icon أو Font Awesome.</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">الترتيب</label>
                <input type="number" name="sort_order" min="0"
                       class="form-control form-input-enhanced @error('sort_order') is-invalid @enderror"
                       value="{{ $value('sort_order', 0) }}">
                @error('sort_order')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if($isEdit)
            <div class="col-12">
                <label class="form-label fw-semibold">الرابط (Slug)</label>
                <input type="text" class="form-control form-input-enhanced bg-light" value="{{ $department->slug }}" dir="ltr" readonly disabled>
                <p class="text-muted fs-12 mb-0 mt-1">يُحدَّث تلقائياً عند تغيير الاسم أو الكلية.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="card custom-card form-card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h6 class="mb-0 fw-semibold fs-15"><i class="ri-file-text-line me-1 text-primary"></i> الوصف التعريفي</h6>
        <span class="badge bg-primary-transparent text-primary">محرر غني</span>
    </div>
    <div class="card-body">
        <label class="form-label fw-semibold" for="description">الوصف</label>
        <p class="text-muted fs-12 mb-2">نبذة عن القسم، مجالات التخصص، والأنشطة البحثية.</p>
        <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="8">{{ $value('description') }}</textarea>
        @error('description')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>
