@php
    $isEdit = isset($center) && $center?->exists;
    $value = fn (string $key, mixed $default = '') => old($key, $isEdit ? ($center->{$key} ?? $default) : $default);
@endphp

<div class="sidebar-sticky">
    <div class="card custom-card form-card mb-4">
        <div class="card-header"><h6 class="mb-0 fw-semibold fs-15"><i class="ri-links-line me-1 text-primary"></i> الارتباطات</h6></div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-semibold">الكلية</label>
                <select name="college_id" class="form-select form-input-enhanced">
                    <option value="">— بدون —</option>
                    @foreach($colleges as $college)
                        <option value="{{ $college->id }}" @selected($value('college_id') == $college->id)>{{ $college->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label fw-semibold">مدير المركز (عضو هيئة)</label>
                <select name="director_id" class="form-select form-input-enhanced">
                    <option value="">— اختر —</option>
                    @foreach($staffMembers as $member)
                        <option value="{{ $member->id }}" @selected($value('director_id') == $member->id)>{{ $member->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-0">
                <label class="form-label fw-semibold">اسم المدير (نص)</label>
                <input type="text" name="director_title" class="form-control form-input-enhanced" value="{{ $value('director_title') }}">
            </div>
        </div>
    </div>

    <div class="card custom-card form-card mb-4">
        <div class="card-header"><h6 class="mb-0 fw-semibold fs-15"><i class="ri-contacts-line me-1 text-primary"></i> التواصل</h6></div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-semibold">البريد</label>
                <input type="email" name="email" class="form-control form-input-enhanced" value="{{ $value('email') }}" dir="ltr">
            </div>
            <div class="mb-0">
                <label class="form-label fw-semibold">الهاتف</label>
                <input type="text" name="phone" class="form-control form-input-enhanced" value="{{ $value('phone') }}" dir="ltr">
            </div>
        </div>
    </div>

    <div class="card custom-card form-card mb-4">
        <div class="card-header"><h6 class="mb-0 fw-semibold fs-15"><i class="ri-settings-3-line me-1 text-primary"></i> الإعدادات</h6></div>
        <div class="card-body">
            <div class="mb-3">
                <label class="form-label fw-semibold">الترتيب</label>
                <input type="number" name="sort_order" min="0" class="form-control form-input-enhanced" value="{{ $value('sort_order', 0) }}">
            </div>
            <div class="seo-options-panel mb-0">
                <div class="seo-option-item">
                    <input class="form-check-input mt-1" type="checkbox" name="is_active" value="1" id="center_is_active" @checked(old('is_active', $isEdit ? $center->is_active : true))>
                    <label class="form-check-label" for="center_is_active">نشط — يظهر في الموقع</label>
                </div>
            </div>
        </div>
    </div>

    <div class="card custom-card form-card sidebar-submit-card">
        <div class="card-body">
            <button type="submit" class="btn btn-primary w-100 mb-2 btn-wave py-2 fw-semibold">
                <i class="ri-save-line me-1"></i> {{ $isEdit ? 'تحديث المركز' : 'حفظ المركز' }}
            </button>
            <a href="{{ route('admin.research.centers.index') }}" class="btn btn-light border w-100 py-2">إلغاء</a>
        </div>
    </div>
</div>
