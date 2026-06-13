@php
    $isEdit = isset($student) && $student?->exists;
    $value = fn (string $key, mixed $default = '') => old($key, $isEdit ? ($student->{$key} ?? $default) : $default);
    $userName = old('name', $isEdit ? ($student->user?->name ?? '') : '');
    $userEmail = old('email', $isEdit ? ($student->user?->email ?? '') : '');
    $statusLabels = [
        'active' => 'نشط',
        'inactive' => 'غير نشط',
        'graduated' => 'متخرج',
        'suspended' => 'موقوف',
    ];
    $selectedStatus = old('status', $isEdit ? $student->status : 'active');
@endphp

<div class="card custom-card form-card mb-4">
    <div class="card-header">
        <h6 class="mb-0 fw-semibold fs-15"><i class="ri-user-line me-1 text-primary"></i> الحساب</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">الاسم الكامل <span class="text-danger">*</span></label>
                <input type="text" name="name" id="studentName"
                       class="form-control form-input-enhanced @error('name') is-invalid @enderror"
                       value="{{ $userName }}" required>
                @error('name')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">البريد الإلكتروني <span class="text-danger">*</span></label>
                <input type="email" name="email" id="studentEmail"
                       class="form-control form-input-enhanced @error('email') is-invalid @enderror"
                       value="{{ $userEmail }}" dir="ltr" required>
                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @unless($isEdit)
            <div class="col-md-6">
                <label class="form-label fw-semibold">كلمة المرور <span class="text-danger">*</span></label>
                <input type="password" name="password"
                       class="form-control form-input-enhanced @error('password') is-invalid @enderror"
                       placeholder="••••••••" required>
                @error('password')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">تأكيد كلمة المرور <span class="text-danger">*</span></label>
                <input type="password" name="password_confirmation"
                       class="form-control form-input-enhanced @error('password_confirmation') is-invalid @enderror"
                       placeholder="••••••••" required>
                @error('password_confirmation')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @endunless
        </div>
    </div>
</div>

<div class="card custom-card form-card mb-4">
    <div class="card-header">
        <h6 class="mb-0 fw-semibold fs-15"><i class="ri-graduation-cap-line me-1 text-primary"></i> البيانات الأكاديمية</h6>
    </div>
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label fw-semibold">رقم الطالب <span class="text-danger">*</span></label>
                <input type="text" name="student_number" id="studentNumber"
                       class="form-control form-input-enhanced @error('student_number') is-invalid @enderror"
                       value="{{ $value('student_number') }}" dir="ltr" required>
                @error('student_number')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">البرنامج</label>
                <select name="program_id" id="studentProgram"
                        class="form-select form-input-enhanced @error('program_id') is-invalid @enderror">
                    <option value="">— بدون برنامج —</option>
                    @foreach($programs as $program)
                        <option value="{{ $program->id }}" @selected(old('program_id', $isEdit ? $student->program_id : null) == $program->id)>
                            {{ $program->name }}
                        </option>
                    @endforeach
                </select>
                @error('program_id')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">الحالة <span class="text-danger">*</span></label>
                <select name="status" id="studentStatus"
                        class="form-select form-input-enhanced @error('status') is-invalid @enderror" required>
                    @foreach($statusLabels as $statusValue => $statusLabel)
                        <option value="{{ $statusValue }}" @selected($selectedStatus === $statusValue)>{{ $statusLabel }}</option>
                    @endforeach
                </select>
                @error('status')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-6">
                <label class="form-label fw-semibold">تاريخ التسجيل</label>
                <input type="date" name="enrollment_date" id="studentEnrollmentDate"
                       class="form-control form-input-enhanced @error('enrollment_date') is-invalid @enderror"
                       value="{{ old('enrollment_date', $isEdit ? optional($student->enrollment_date)->format('Y-m-d') : date('Y-m-d')) }}">
                @error('enrollment_date')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
        </div>
    </div>
</div>
