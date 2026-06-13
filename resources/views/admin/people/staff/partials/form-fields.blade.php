@php
    $isEdit = isset($staff) && $staff?->exists;
    $value = fn (string $key, mixed $default = '') => old($key, $isEdit ? ($staff->{$key} ?? $default) : $default);
    $iconRaw = old('icon', $isEdit ? ($staff->icon ?? '') : 'fa-user-tie');
    $iconClass = trim((string) ($iconRaw ?: 'ri-user-line'));
    if ($iconClass && ! str_contains($iconClass, ' ') && str_starts_with($iconClass, 'fa-')) {
        $iconClass = 'fas ' . $iconClass;
    }
    $selectedType = old('type', $isEdit ? ($staff->type?->value ?? '') : '');
@endphp

<div class="card custom-card form-card mb-4">
    <div class="card-header">
        <h6 class="mb-0 fw-semibold fs-15"><i class="ri-user-line me-1 text-primary"></i> المعلومات الأساسية</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">النوع <span class="text-danger">*</span></label>
                <select name="type" id="staffType"
                        class="form-select form-input-enhanced @error('type') is-invalid @enderror" required>
                    @foreach($types as $type)
                        <option value="{{ $type->value }}" @selected($selectedType === $type->value)>{{ $type->label() }}</option>
                    @endforeach
                </select>
                @error('type')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">الاسم <span class="text-danger">*</span></label>
                <input type="text" name="name" id="staffName"
                       class="form-control form-input-enhanced @error('name') is-invalid @enderror"
                       value="{{ $value('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">المنصب</label>
                <input type="text" name="position" id="staffPosition"
                       class="form-control form-input-enhanced @error('position') is-invalid @enderror"
                       value="{{ $value('position') }}">
                @error('position')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">التخصص</label>
                <input type="text" name="specialty"
                       class="form-control form-input-enhanced @error('specialty') is-invalid @enderror"
                       value="{{ $value('specialty') }}">
                @error('specialty')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">اللقب الأكاديمي</label>
                <input type="text" name="academic_title"
                       class="form-control form-input-enhanced @error('academic_title') is-invalid @enderror"
                       value="{{ $value('academic_title') }}">
                @error('academic_title')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">الأيقونة</label>
                <div class="d-flex align-items-center gap-2">
                    <span class="icon-preview-box entity-form-icon-inline" id="staffIconPreview">
                        <i class="{{ $iconClass }}"></i>
                    </span>
                    <input type="text" name="icon" id="staffIcon"
                           class="form-control form-input-enhanced @error('icon') is-invalid @enderror"
                           value="{{ $iconRaw }}" placeholder="fa-user-tie" dir="ltr">
                </div>
                @error('icon')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                @enderror
            </div>
            @if($isEdit)
            <div class="col-12">
                <label class="form-label fw-semibold">الرابط (Slug)</label>
                <input type="text" class="form-control form-input-enhanced bg-light" value="{{ $staff->slug }}" dir="ltr" readonly disabled>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="card custom-card form-card mb-4">
    <div class="card-header">
        <h6 class="mb-0 fw-semibold fs-15"><i class="ri-building-2-line me-1 text-primary"></i> الانتماء الأكاديمي</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">الكلية</label>
                <select name="college_id" id="staffCollege"
                        class="form-select form-input-enhanced @error('college_id') is-invalid @enderror">
                    <option value="">—</option>
                    @foreach($colleges as $collegeOption)
                        <option value="{{ $collegeOption->id }}" @selected(old('college_id', $isEdit ? $staff->college_id : null) == $collegeOption->id)>
                            {{ $collegeOption->name }}
                        </option>
                    @endforeach
                </select>
                @error('college_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">القسم</label>
                <select name="department_id"
                        class="form-select form-input-enhanced @error('department_id') is-invalid @enderror">
                    <option value="">—</option>
                    @foreach($departments as $departmentOption)
                        <option value="{{ $departmentOption->id }}" @selected(old('department_id', $isEdit ? $staff->department_id : null) == $departmentOption->id)>
                            {{ $departmentOption->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">البرنامج</label>
                <select name="program_id"
                        class="form-select form-input-enhanced @error('program_id') is-invalid @enderror">
                    <option value="">—</option>
                    @foreach($programs as $programOption)
                        <option value="{{ $programOption->id }}" @selected(old('program_id', $isEdit ? $staff->program_id : null) == $programOption->id)>
                            {{ $programOption->name }}
                        </option>
                    @endforeach
                </select>
                @error('program_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">الترتيب</label>
                <input type="number" name="sort_order" min="0"
                       class="form-control form-input-enhanced @error('sort_order') is-invalid @enderror"
                       value="{{ $value('sort_order', 0) }}">
                @error('sort_order')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>

<div class="card custom-card form-card mb-4">
    <div class="card-header">
        <h6 class="mb-0 fw-semibold fs-15"><i class="ri-contacts-line me-1 text-primary"></i> التواصل والإحصائيات</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            @include('admin.people.staff.partials.profile-fields', ['staff' => $staff ?? null])
        </div>
    </div>
</div>

<div class="card custom-card form-card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h6 class="mb-0 fw-semibold fs-15"><i class="ri-file-text-line me-1 text-primary"></i> النبذة التعريفية</h6>
        <span class="badge bg-primary-transparent text-primary">محرر غني</span>
    </div>
    <div class="card-body">
        <textarea id="bio" name="bio" class="form-control @error('bio') is-invalid @enderror" rows="8">{{ old('bio', $isEdit ? $staff->bio : '') }}</textarea>
        @error('bio')
            <div class="invalid-feedback d-block">{{ $message }}</div>
        @enderror
    </div>
</div>
