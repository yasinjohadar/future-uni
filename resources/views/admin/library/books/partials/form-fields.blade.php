@php
    $isEdit = isset($book) && $book?->exists;
    $value = fn (string $key, mixed $default = '') => old($key, $isEdit ? ($book->{$key} ?? $default) : $default);
    $iconRaw = old('icon', $isEdit ? ($book->icon ?? '') : '');
    $iconClass = college_fa_icon($iconRaw, 'fa-book');
    $chaptersText = old('chapters_text', $isEdit ? implode("\n", $book->chapters ?? []) : '');
    $tagsText = old('tags_text', $isEdit ? implode("\n", $book->tags ?? []) : '');
@endphp

<div class="card custom-card form-card mb-4">
    <div class="card-header"><h6 class="mb-0 fw-semibold fs-15"><i class="ri-book-line me-1 text-primary"></i> المعلومات الأساسية</h6></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-8">
                <label class="form-label fw-semibold">العنوان <span class="text-danger">*</span></label>
                <input type="text" name="title" class="form-control form-input-enhanced @error('title') is-invalid @enderror" value="{{ $value('title') }}" required>
                @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">المؤلف <span class="text-danger">*</span></label>
                <input type="text" name="author" class="form-control form-input-enhanced @error('author') is-invalid @enderror" value="{{ $value('author') }}" required>
                @error('author')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">التصنيف <span class="text-danger">*</span></label>
                <select name="library_category_id" class="form-select form-input-enhanced @error('library_category_id') is-invalid @enderror" required>
                    <option value="">— اختر —</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" @selected($value('library_category_id') == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('library_category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">الأيقونة</label>
                <div class="d-flex align-items-center gap-2">
                    <span class="icon-preview-box entity-form-icon-inline"><i class="{{ $iconClass }}"></i></span>
                    <input type="text" name="icon" class="form-control form-input-enhanced" value="{{ $iconRaw }}" placeholder="fa-book" dir="ltr">
                </div>
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">اللون</label>
                <input type="text" name="color" class="form-control form-input-enhanced" value="{{ $value('color') }}" placeholder="#0F172A" dir="ltr">
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">الوصف</label>
                <textarea name="description" rows="4" class="form-control form-input-enhanced">{{ $value('description') }}</textarea>
            </div>
        </div>
    </div>
</div>

<div class="card custom-card form-card mb-4">
    <div class="card-header"><h6 class="mb-0 fw-semibold fs-15"><i class="ri-file-info-line me-1 text-primary"></i> بيانات النشر والتوفر</h6></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label fw-semibold">ISBN</label><input type="text" name="isbn" class="form-control form-input-enhanced" value="{{ $value('isbn') }}" dir="ltr"></div>
            <div class="col-md-4"><label class="form-label fw-semibold">الناشر</label><input type="text" name="publisher" class="form-control form-input-enhanced" value="{{ $value('publisher') }}"></div>
            <div class="col-md-4"><label class="form-label fw-semibold">الطبعة</label><input type="text" name="edition" class="form-control form-input-enhanced" value="{{ $value('edition') }}"></div>
            <div class="col-md-3"><label class="form-label fw-semibold">سنة النشر</label><input type="text" name="publication_year" class="form-control form-input-enhanced" value="{{ $value('publication_year') }}"></div>
            <div class="col-md-3"><label class="form-label fw-semibold">الصفحات</label><input type="number" name="pages" min="0" class="form-control form-input-enhanced" value="{{ $value('pages', 0) }}"></div>
            <div class="col-md-3"><label class="form-label fw-semibold">اللغة</label><input type="text" name="language" class="form-control form-input-enhanced" value="{{ $value('language', 'العربية') }}"></div>
            <div class="col-md-3"><label class="form-label fw-semibold">التقييم (0-5)</label><input type="number" name="rating" min="0" max="5" step="0.1" class="form-control form-input-enhanced" value="{{ $value('rating', 0) }}"></div>
            <div class="col-md-4"><label class="form-label fw-semibold">إجمالي النسخ</label><input type="number" name="copies_total" min="0" class="form-control form-input-enhanced" value="{{ $value('copies_total', 0) }}"></div>
            <div class="col-md-4"><label class="form-label fw-semibold">النسخ المتاحة</label><input type="number" name="copies_available" min="0" class="form-control form-input-enhanced" value="{{ $value('copies_available', 0) }}"></div>
            <div class="col-md-4"><label class="form-label fw-semibold">موقع الرف</label><input type="text" name="shelf_location" class="form-control form-input-enhanced" value="{{ $value('shelf_location') }}"></div>
        </div>
    </div>
</div>

<div class="card custom-card form-card mb-4">
    <div class="card-header"><h6 class="mb-0 fw-semibold fs-15"><i class="ri-list-ordered me-1 text-primary"></i> الفهرس والوسوم</h6></div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">فهرس المحتويات</label>
                <textarea name="chapters_text" rows="6" class="form-control form-input-enhanced" placeholder="سطر لكل فصل">{{ $chaptersText }}</textarea>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">الوسوم</label>
                <textarea name="tags_text" rows="6" class="form-control form-input-enhanced" placeholder="سطر أو فاصلة لكل وسم">{{ $tagsText }}</textarea>
            </div>
        </div>
    </div>
</div>
