<div class="col-md-4">
    <label class="form-label fw-semibold">البريد الإلكتروني</label>
    <input type="email" name="email" class="form-control form-input-enhanced @error('email') is-invalid @enderror"
           value="{{ old('email', optional($staff)->email ?? '') }}" dir="ltr" placeholder="name@university.edu">
    @error('email')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="col-md-4">
    <label class="form-label fw-semibold">الهاتف</label>
    <input type="text" name="phone" class="form-control form-input-enhanced @error('phone') is-invalid @enderror"
           value="{{ old('phone', optional($staff)->phone ?? '') }}" dir="ltr">
    @error('phone')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
<div class="col-md-4">
    <label class="form-label fw-semibold">المكتب</label>
    <input type="text" name="office" class="form-control form-input-enhanced @error('office') is-invalid @enderror"
           value="{{ old('office', optional($staff)->office ?? '') }}">
    @error('office')
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>

<div class="col-12">
    <label class="form-label fw-semibold d-block mb-2">إحصائيات البروفايل</label>
    <div class="row g-3">
        <div class="col-md-3">
            <label class="form-label fs-12 text-muted">منشورات علمية</label>
            <input type="number" name="stats[publications]" min="0"
                   class="form-control form-input-enhanced"
                   value="{{ old('stats.publications', data_get($staff ?? null, 'stats.publications')) }}">
        </div>
        <div class="col-md-3">
            <label class="form-label fs-12 text-muted">استشهادات</label>
            <input type="number" name="stats[citations]" min="0"
                   class="form-control form-input-enhanced"
                   value="{{ old('stats.citations', data_get($staff ?? null, 'stats.citations')) }}">
        </div>
        <div class="col-md-3">
            <label class="form-label fs-12 text-muted">h-index</label>
            <input type="number" name="stats[hIndex]" min="0"
                   class="form-control form-input-enhanced"
                   value="{{ old('stats.hIndex', data_get($staff ?? null, 'stats.hIndex')) }}">
        </div>
        <div class="col-md-3">
            <label class="form-label fs-12 text-muted">سنوات الخبرة</label>
            <input type="number" name="stats[experience]" min="0"
                   class="form-control form-input-enhanced"
                   value="{{ old('stats.experience', data_get($staff ?? null, 'stats.experience')) }}">
        </div>
    </div>
</div>
