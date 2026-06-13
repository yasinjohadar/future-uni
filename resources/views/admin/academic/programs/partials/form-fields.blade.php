@php
    $isEdit = isset($program) && $program?->exists;
    $value = fn (string $key, mixed $default = '') => old($key, $isEdit ? ($program->{$key} ?? $default) : $default);
    $selectedCollegeId = old('college_id', $isEdit ? $program->college_id : ($selectedCollegeId ?? null));
    $selectedDepartmentId = old('department_id', $isEdit ? $program->department_id : ($selectedDepartmentId ?? null));
    $selectedLevel = old('level', $isEdit ? ($program->level?->value ?? '') : '');
@endphp

<div class="card custom-card form-card mb-4">
    <div class="card-header">
        <h6 class="mb-0 fw-semibold fs-15"><i class="ri-information-line me-1 text-primary"></i> المعلومات الأساسية</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">الكلية <span class="text-danger">*</span></label>
                <select name="college_id" id="programCollege"
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
                <label class="form-label fw-semibold">القسم</label>
                <select name="department_id" id="programDepartment"
                        class="form-select form-input-enhanced @error('department_id') is-invalid @enderror">
                    <option value="">بدون قسم</option>
                    @foreach($departments as $departmentOption)
                        <option value="{{ $departmentOption->id }}" @selected($selectedDepartmentId == $departmentOption->id)>
                            {{ $departmentOption->name }}
                        </option>
                    @endforeach
                </select>
                @error('department_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">اسم البرنامج <span class="text-danger">*</span></label>
                <input type="text" name="name" id="programName"
                       class="form-control form-input-enhanced @error('name') is-invalid @enderror"
                       value="{{ $value('name') }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">المستوى <span class="text-danger">*</span></label>
                <select name="level" id="programLevel"
                        class="form-select form-input-enhanced @error('level') is-invalid @enderror" required>
                    @foreach($levels as $level)
                        <option value="{{ $level->value }}" @selected($selectedLevel === $level->value)>
                            {{ $level->label() }}
                        </option>
                    @endforeach
                </select>
                @error('level')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if($isEdit)
            <div class="col-12">
                <label class="form-label fw-semibold">الرابط (Slug)</label>
                <input type="text" class="form-control form-input-enhanced bg-light" value="{{ $program->slug }}" dir="ltr" readonly disabled>
                <p class="text-muted fs-12 mb-0 mt-1">يُحدَّث تلقائياً عند تغيير اسم البرنامج.</p>
            </div>
            @endif
        </div>
    </div>
</div>

<div class="card custom-card form-card mb-4">
    <div class="card-header">
        <h6 class="mb-0 fw-semibold fs-15"><i class="ri-time-line me-1 text-primary"></i> تفاصيل الدراسة</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-4">
                <label class="form-label fw-semibold">المدة</label>
                <input type="text" name="duration" id="programDuration"
                       class="form-control form-input-enhanced @error('duration') is-invalid @enderror"
                       value="{{ $value('duration') }}" placeholder="4 سنوات">
                @error('duration')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-4">
                <label class="form-label fw-semibold">الساعات المعتمدة</label>
                <input type="number" name="credits" id="programCredits" min="0"
                       class="form-control form-input-enhanced @error('credits') is-invalid @enderror"
                       value="{{ $value('credits') }}">
                @error('credits')
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
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <h6 class="mb-0 fw-semibold fs-15"><i class="ri-file-text-line me-1 text-primary"></i> المحتوى التعريفي</h6>
        <span class="badge bg-primary-transparent text-primary">محرر غني</span>
    </div>
    <div class="card-body">
        <div class="mb-4">
            <label class="form-label fw-semibold" for="description">الوصف</label>
            <p class="text-muted fs-12 mb-2">نبذة عن البرنامج، مميزاته، والخطة الدراسية.</p>
            <textarea id="description" name="description" class="form-control @error('description') is-invalid @enderror" rows="8">{{ $value('description') }}</textarea>
            @error('description')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
        <div>
            <label class="form-label fw-semibold" for="requirements">متطلبات القبول</label>
            <p class="text-muted fs-12 mb-2">شروط القبول، المستندات المطلوبة، ومعايير التسجيل.</p>
            <textarea id="requirements" name="requirements" class="form-control @error('requirements') is-invalid @enderror" rows="6">{{ $value('requirements') }}</textarea>
            @error('requirements')
                <div class="invalid-feedback d-block">{{ $message }}</div>
            @enderror
        </div>
    </div>
</div>
