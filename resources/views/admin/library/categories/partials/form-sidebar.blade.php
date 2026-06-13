@php
    $isEdit = isset($category) && $category?->exists;
    $value = fn (string $key, mixed $default = '') => old($key, $isEdit ? ($category->{$key} ?? $default) : $default);
@endphp

<div class="sidebar-sticky">
    <div class="card custom-card form-card mb-4">
        <div class="card-header"><h6 class="mb-0 fw-semibold fs-15"><i class="ri-settings-3-line me-1 text-primary"></i> الإعدادات</h6></div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-semibold">الترتيب</label>
                <input type="number" name="sort_order" min="0" class="form-control form-input-enhanced" value="{{ $value('sort_order', 0) }}">
            </div>
            <div class="seo-options-panel mb-0">
                <div class="seo-option-item">
                    <input class="form-check-input mt-1" type="checkbox" name="is_active" value="1" id="category_is_active" @checked(old('is_active', $isEdit ? $category->is_active : true))>
                    <label class="form-check-label" for="category_is_active">نشط — يظهر في الموقع</label>
                </div>
            </div>
        </div>
    </div>

    <div class="card custom-card form-card sidebar-submit-card">
        <div class="card-body">
            <button type="submit" class="btn btn-primary w-100 mb-2 btn-wave py-2 fw-semibold">
                <i class="ri-save-line me-1"></i> {{ $isEdit ? 'تحديث التصنيف' : 'حفظ التصنيف' }}
            </button>
            <a href="{{ route('admin.library.categories.index') }}" class="btn btn-light border w-100 py-2">إلغاء</a>
        </div>
    </div>
</div>
