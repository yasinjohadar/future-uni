@php
    $isEdit = isset($college) && $college?->exists;
    $value = fn (string $key, mixed $default = '') => old($key, $isEdit ? ($college->{$key} ?? $default) : $default);
    $iconRaw = old('icon', $isEdit ? ($college->icon ?? '') : '');
    $iconClass = trim((string) ($iconRaw ?: 'ri-building-line'));
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
                <label class="form-label fw-semibold">اسم الكلية <span class="text-danger">*</span></label>
                <input type="text" name="name" id="collegeName"
                       class="form-control form-input-enhanced @error('name') is-invalid @enderror"
                       value="{{ $value('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">التصنيف</label>
                <input type="text" name="category"
                       class="form-control form-input-enhanced @error('category') is-invalid @enderror"
                       value="{{ $value('category', 'all') }}" placeholder="all, business, engineering...">
                @error('category')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
                <p class="text-muted fs-12 mb-0 mt-1">يُستخدم لتجميع الكليات في صفحة الموقع.</p>
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">الأيقونة</label>
                <div class="d-flex align-items-center gap-2">
                    <span class="icon-preview-box entity-form-icon-inline" id="collegeIconPreview">
                        <i class="{{ $iconClass }}"></i>
                    </span>
                    <input type="text" name="icon" id="collegeIcon"
                           class="form-control form-input-enhanced @error('icon') is-invalid @enderror"
                           value="{{ $iconRaw }}" placeholder="ri-building-line أو fa-chart-line" dir="ltr">
                </div>
                @error('icon')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
                <p class="text-muted fs-12 mb-0 mt-1">Remix Icon أو Font Awesome (مثل <code dir="ltr">fa-chart-line</code>).</p>
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
                <input type="text" class="form-control form-input-enhanced bg-light" value="{{ $college->slug }}" dir="ltr" readonly disabled>
                <p class="text-muted fs-12 mb-0 mt-1">يُحدَّث تلقائياً عند تغيير اسم الكلية.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="card custom-card form-card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h6 class="mb-0 fw-semibold fs-15"><i class="ri-file-text-line me-1 text-primary"></i> المحتوى التعريفي</h6>
        <span class="badge bg-primary-transparent text-primary">محرر غني</span>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <label class="form-label fw-semibold" for="description">الوصف</label>
            <p class="text-muted fs-12 mb-2">نبذة شاملة عن الكلية، الأهداف، والمخرجات التعليمية.</p>
            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="8">{{ $value('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold" for="vision">الرؤية</label>
                <textarea id="vision" name="vision" class="form-control @error('vision') is-invalid @enderror" rows="5">{{ $value('vision') }}</textarea>
                @error('vision')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold" for="mission">الرسالة</label>
                <textarea id="mission" name="mission" class="form-control @error('mission') is-invalid @enderror" rows="5">{{ $value('mission') }}</textarea>
                @error('mission')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="card custom-card form-card mb-4">
    <div class="card-header">
        <h6 class="mb-0 fw-semibold fs-15"><i class="ri-bar-chart-box-line me-1 text-primary"></i> بيانات إضافية</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">سنة التأسيس</label>
                <input type="text" name="established"
                       class="form-control form-input-enhanced @error('established') is-invalid @enderror"
                       value="{{ $value('established') }}" placeholder="2010">
                @error('established')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">عدد الطلاب</label>
                <input type="text" name="students_count"
                       class="form-control form-input-enhanced @error('students_count') is-invalid @enderror"
                       value="{{ $value('students_count') }}" placeholder="3,500+">
                @error('students_count')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">المبنى</label>
                <input type="text" name="building"
                       class="form-control form-input-enhanced @error('building') is-invalid @enderror"
                       value="{{ $value('building') }}">
                @error('building')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-12">
                <label class="form-label fw-semibold">الاعتماد</label>
                <input type="text" name="accreditation"
                       class="form-control form-input-enhanced @error('accreditation') is-invalid @enderror"
                       value="{{ $value('accreditation') }}">
                @error('accreditation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>
