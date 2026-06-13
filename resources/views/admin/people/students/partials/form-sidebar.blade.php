@php
    $isEdit = isset($student) && $student?->exists;
    $name = old('name', $isEdit ? ($student->user?->name ?? 'طالب') : 'طالب');
    $initial = mb_strtoupper(mb_substr($name ?: 'ط', 0, 1));
    $studentNumber = old('student_number', $isEdit ? $student->student_number : '—');
    $statusLabels = [
        'active' => 'نشط',
        'inactive' => 'غير نشط',
        'graduated' => 'متخرج',
        'suspended' => 'موقوف',
    ];
    $selectedStatus = old('status', $isEdit ? $student->status : 'active');
    $programName = $isEdit
        ? ($student->program?->name ?? 'بدون برنامج')
        : ($programs->firstWhere('id', old('program_id'))?->name ?? 'بدون برنامج');
@endphp

<div class="sidebar-sticky">
    <div class="card custom-card form-card mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-semibold fs-15"><i class="ri-user-smile-line me-1 text-primary"></i> معاينة الطالب</h6>
        </div>
        <div class="card-body text-center">
            <div class="user-avatar-preview-wrap mx-auto" style="width: 5.5rem; height: 5.5rem;">
                <span id="studentInitialPreview" class="user-avatar-initial">{{ $initial }}</span>
            </div>
            <p class="fw-semibold fs-14 mb-1 mt-3" id="studentNamePreview">{{ $name ?: 'اسم الطالب' }}</p>
            <p class="text-muted fs-12 mb-0" dir="ltr" id="studentNumberPreview">{{ $studentNumber ?: '—' }}</p>
            <span class="badge bg-primary-transparent text-primary mt-2" id="studentStatusPreview">
                {{ $statusLabels[$selectedStatus] ?? $selectedStatus }}
            </span>
        </div>
    </div>

    @if($isEdit)
    <div class="card custom-card form-card mb-4">
        <div class="card-header">
            <h6 class="mb-0 fw-semibold fs-15"><i class="ri-information-line me-1 text-primary"></i> ملخص</h6>
        </div>
        <div class="card-body p-0">
            <div class="entity-form-stat-list">
                <div class="entity-form-stat-item">
                    <span class="entity-form-stat-item__icon bg-purple-transparent text-purple"><i class="ri-book-open-line"></i></span>
                    <div>
                        <span class="entity-form-stat-item__value fs-13" id="studentProgramPreview">{{ $programName }}</span>
                        <span class="entity-form-stat-item__label">البرنامج</span>
                    </div>
                </div>
                <div class="entity-form-stat-item">
                    <span class="entity-form-stat-item__icon bg-cyan-transparent text-cyan"><i class="ri-calendar-line"></i></span>
                    <div>
                        <span class="entity-form-stat-item__value" id="studentEnrollmentPreview">
                            {{ optional($student->enrollment_date)->format('Y-m-d') ?: '—' }}
                        </span>
                        <span class="entity-form-stat-item__label">تاريخ التسجيل</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @else
    <div class="card custom-card form-card mb-4">
        <div class="card-body">
            <div class="form-hint-banner border-0 mb-0">
                <span class="form-hint-banner__icon"><i class="ri-lightbulb-line"></i></span>
                <div>
                    <p class="fw-semibold mb-1 fs-13">نصيحة</p>
                    <p class="text-muted fs-12 mb-0">رقم الطالب يجب أن يكون فريداً. يمكن ربط الطالب ببرنامج أكاديمي لاحقاً.</p>
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="card custom-card form-card sidebar-submit-card">
        <div class="card-body">
            <button type="submit" class="btn btn-primary w-100 mb-2 btn-wave">
                <i class="ri-save-line me-1"></i> {{ $isEdit ? 'حفظ التعديلات' : 'إنشاء الطالب' }}
            </button>
            <a href="{{ route('admin.people.students.index') }}" class="btn btn-light border w-100">
                <i class="ri-close-line me-1"></i> إلغاء
            </a>
        </div>
    </div>
</div>
