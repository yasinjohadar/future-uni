<div class="row g-3">
    <div class="col-md-6">
        <label class="form-label fw-semibold" for="site_logo">رابط الشعار</label>
        <input type="text" name="site_logo" id="site_logo"
               class="form-control form-input-enhanced @error('site_logo') is-invalid @enderror"
               value="{{ old('site_logo', $settings['site_logo'] ?? '') }}" placeholder="/storage/logo.png" dir="ltr">
        @error('site_logo')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold" for="site_favicon">رابط الأيقونة (Favicon)</label>
        <input type="text" name="site_favicon" id="site_favicon"
               class="form-control form-input-enhanced @error('site_favicon') is-invalid @enderror"
               value="{{ old('site_favicon', $settings['site_favicon'] ?? '') }}" placeholder="/storage/favicon.ico" dir="ltr">
        @error('site_favicon')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold" for="default_seo_title">عنوان SEO الافتراضي</label>
        <input type="text" name="default_seo_title" id="default_seo_title"
               class="form-control form-input-enhanced @error('default_seo_title') is-invalid @enderror"
               value="{{ old('default_seo_title', $settings['default_seo_title'] ?? '') }}"
               placeholder="جامعة المستقبل">
        @error('default_seo_title')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="col-md-6">
        <label class="form-label fw-semibold" for="default_seo_description">وصف SEO الافتراضي</label>
        <textarea name="default_seo_description" id="default_seo_description" rows="3"
                  class="form-control form-input-enhanced @error('default_seo_description') is-invalid @enderror"
                  placeholder="جامعة المستقبل — تعليم أكاديمي متميز">{{ old('default_seo_description', $settings['default_seo_description'] ?? '') }}</textarea>
        @error('default_seo_description')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
</div>
