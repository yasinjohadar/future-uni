@php
    $isEdit = isset($category) && $category?->exists;
    $value = fn (string $key, mixed $default = '') => old($key, $isEdit ? ($category->{$key} ?? $default) : $default);
    $iconRaw = old('icon', $isEdit ? ($category->icon ?? '') : '');
    $iconClass = college_fa_icon($iconRaw, 'fa-book');
@endphp

<div class="card custom-card form-card mb-4">
    <div class="card-header"><h6 class="mb-0 fw-semibold fs-15"><i class="ri-information-line me-1 text-primary"></i> معلومات التصنيف</h6></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-semibold">الاسم <span class="text-danger">*</span></label>
                <input type="text" name="name" class="form-control form-input-enhanced @error('name') is-invalid @enderror" value="{{ $value('name') }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">Slug</label>
                <input type="text" name="slug" class="form-control form-input-enhanced" value="{{ $value('slug') }}" dir="ltr" placeholder="engineering">
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">الأيقونة</label>
                <div class="d-flex align-items-center gap-2">
                    <span class="icon-preview-box entity-form-icon-inline"><i class="{{ $iconClass }}"></i></span>
                    <input type="text" name="icon" class="form-control form-input-enhanced" value="{{ $iconRaw }}" placeholder="fa-gears" dir="ltr">
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">اللون</label>
                <input type="text" name="color" class="form-control form-input-enhanced" value="{{ $value('color') }}" placeholder="#0F172A" dir="ltr">
            </div>
        </div>
    </div>
</div>
