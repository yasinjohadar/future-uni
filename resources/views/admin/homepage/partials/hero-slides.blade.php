<div class="card custom-card data-table-card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="fw-bold fs-16"><i class="ri-slideshow-line me-1 text-primary"></i> شرائح العرض الرئيسية</span>
            <span class="table-count-badge">{{ number_format($heroSlides->count()) }}</span>
        </div>
        <button class="btn btn-primary btn-sm btn-wave" type="button" data-bs-toggle="collapse" data-bs-target="#addHeroSlide" aria-expanded="false">
            <i class="ri-add-line me-1"></i> إضافة شريحة
        </button>
    </div>

    <div class="collapse homepage-add-panel" id="addHeroSlide">
        <div class="homepage-add-panel__inner">
            <h6 class="fw-semibold mb-3"><i class="ri-add-circle-line me-1 text-primary"></i> شريحة جديدة</h6>
            <form action="{{ route('admin.homepage.hero-slides.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">العنوان <span class="text-danger">*</span></label>
                        <input type="text" name="title" class="form-control form-input-enhanced" placeholder="عنوان الشريحة" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">جزء مميز</label>
                        <input type="text" name="title_accent" class="form-control form-input-enhanced" placeholder="نص بلون مختلف">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الشارة</label>
                        <input type="text" name="badge" class="form-control form-input-enhanced" placeholder="مثال: جديد">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">الترتيب</label>
                        <input type="number" name="sort_order" class="form-control form-input-enhanced" placeholder="0" min="0">
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <div class="seo-options-panel w-100 mb-0">
                            <div class="seo-option-item">
                                <input class="form-check-input mt-1" type="checkbox" name="is_active" value="1" id="new_slide_active" checked>
                                <label class="form-check-label" for="new_slide_active">نشط</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">الوصف</label>
                        <textarea name="description" class="form-control form-input-enhanced" rows="2" placeholder="وصف مختصر للشريحة"></textarea>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">زر رئيسي — النص</label>
                        <input type="text" name="primary_btn_label" class="form-control form-input-enhanced" placeholder="مثال: اكتشف المزيد">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">زر رئيسي — الرابط</label>
                        <input type="text" name="primary_btn_url" class="form-control form-input-enhanced" placeholder="/programs" dir="ltr">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">زر ثانوي — النص</label>
                        <input type="text" name="secondary_btn_label" class="form-control form-input-enhanced">
                    </div>
                    <div class="col-md-6">
                        <label class="form-label fw-semibold">زر ثانوي — الرابط</label>
                        <input type="text" name="secondary_btn_url" class="form-control form-input-enhanced" dir="ltr">
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">صورة الخلفية</label>
                        <input type="text" name="background_image" class="form-control form-input-enhanced" placeholder="hero/slide-1.jpg" dir="ltr">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm btn-wave">
                            <i class="ri-save-line me-1"></i> حفظ الشريحة
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table data-table mb-0">
                <thead>
                    <tr>
                        <th style="width: 50px;">#</th>
                        <th style="min-width: 260px;">العنوان</th>
                        <th style="min-width: 80px;">الترتيب</th>
                        <th style="min-width: 120px;">الحالة</th>
                        <th style="min-width: 120px;">إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($heroSlides as $slide)
                        <tr>
                            <td class="text-muted fw-medium">{{ $loop->iteration }}</td>
                            <td>
                                <div class="fw-semibold">{{ $slide->title }}</div>
                                @if($slide->title_accent)
                                    <span class="text-primary fs-12">{{ $slide->title_accent }}</span>
                                @endif
                                @if($slide->badge)
                                    <span class="badge-soft badge-soft-info ms-1 fs-11">{{ $slide->badge }}</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge-soft badge-soft-secondary">{{ $slide->sort_order }}</span>
                            </td>
                            <td>
                                <form action="{{ route('admin.homepage.hero-slides.toggle-active', $slide) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="activation-pill {{ $slide->is_active ? 'activation-pill--active' : 'activation-pill--inactive' }} mb-0"
                                            title="{{ $slide->is_active ? 'إيقاف الشريحة' : 'تفعيل الشريحة' }}">
                                        <i class="ri-shut-down-line"></i>
                                        <span class="toggle-label">{{ $slide->is_active ? 'نشط' : 'غير نشط' }}</span>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button"
                                            class="action-btn action-btn--edit"
                                            title="تعديل"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editHeroSlide{{ $slide->id }}">
                                        <i class="ri-pencil-line"></i>
                                    </button>
                                    <button type="button"
                                            class="action-btn action-btn--delete"
                                            title="حذف"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteHeroSlide{{ $slide->id }}">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-state-icon"><i class="ri-slideshow-line"></i></div>
                                    <h5 class="fw-bold mb-2">لا توجد شرائح</h5>
                                    <p class="text-muted mb-3">أضف شريحة عرض لصفحة الرئيسية.</p>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#addHeroSlide">
                                        <i class="ri-add-line me-1"></i> إضافة شريحة
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
