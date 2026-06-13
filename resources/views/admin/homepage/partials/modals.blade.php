{{-- Hero slide edit & delete modals --}}
@foreach($heroSlides as $slide)
    <div class="modal fade" id="editHeroSlide{{ $slide->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <form action="{{ route('admin.homepage.hero-slides.update', $slide) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold"><i class="ri-pencil-line me-1 text-primary"></i> تعديل الشريحة</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">العنوان <span class="text-danger">*</span></label>
                                <input type="text" name="title" class="form-control form-input-enhanced" value="{{ $slide->title }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">جزء مميز</label>
                                <input type="text" name="title_accent" class="form-control form-input-enhanced" value="{{ $slide->title_accent }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">الشارة</label>
                                <input type="text" name="badge" class="form-control form-input-enhanced" value="{{ $slide->badge }}">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">الترتيب</label>
                                <input type="number" name="sort_order" class="form-control form-input-enhanced" value="{{ $slide->sort_order }}" min="0">
                            </div>
                            <div class="col-md-4 d-flex align-items-end">
                                <div class="seo-options-panel w-100 mb-0">
                                    <div class="seo-option-item">
                                        <input class="form-check-input mt-1" type="checkbox" name="is_active" value="1" id="edit_slide_active_{{ $slide->id }}" @checked($slide->is_active)>
                                        <label class="form-check-label" for="edit_slide_active_{{ $slide->id }}">نشط</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">الوصف</label>
                                <textarea name="description" class="form-control form-input-enhanced" rows="2">{{ $slide->description }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">زر رئيسي — النص</label>
                                <input type="text" name="primary_btn_label" class="form-control form-input-enhanced" value="{{ $slide->primary_btn_label }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">زر رئيسي — الرابط</label>
                                <input type="text" name="primary_btn_url" class="form-control form-input-enhanced" value="{{ $slide->primary_btn_url }}" dir="ltr">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">زر ثانوي — النص</label>
                                <input type="text" name="secondary_btn_label" class="form-control form-input-enhanced" value="{{ $slide->secondary_btn_label }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">زر ثانوي — الرابط</label>
                                <input type="text" name="secondary_btn_url" class="form-control form-input-enhanced" value="{{ $slide->secondary_btn_url }}" dir="ltr">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">صورة الخلفية</label>
                                <input type="text" name="background_image" class="form-control form-input-enhanced" value="{{ $slide->background_image }}" dir="ltr">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary btn-wave">
                            <i class="ri-save-line me-1"></i> تحديث
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-admin.confirm-modal
        :id="'deleteHeroSlide' . $slide->id"
        title="تأكيد حذف الشريحة"
        message="سيتم حذف الشريحة نهائياً من الصفحة الرئيسية."
        :subject="$slide->title"
        :subject-meta="'الترتيب: ' . $slide->sort_order"
        icon="ri-slideshow-line"
        :action="route('admin.homepage.hero-slides.destroy', $slide)"
        method="DELETE"
        confirm-text="نعم، احذف الشريحة"
    />
@endforeach

{{-- Stats edit & delete modals --}}
@foreach($stats as $stat)
    <div class="modal fade" id="editStat{{ $stat->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form action="{{ route('admin.homepage.stats.update', $stat) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold"><i class="ri-pencil-line me-1 text-primary"></i> تعديل الإحصائية</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">الأيقونة</label>
                                <input type="text" name="icon" class="form-control form-input-enhanced" value="{{ $stat->icon }}" dir="ltr">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">القيمة <span class="text-danger">*</span></label>
                                <input type="text" name="value" class="form-control form-input-enhanced" value="{{ $stat->value }}" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label fw-semibold">الترتيب</label>
                                <input type="number" name="sort_order" class="form-control form-input-enhanced" value="{{ $stat->sort_order }}" min="0">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">التسمية <span class="text-danger">*</span></label>
                                <input type="text" name="label" class="form-control form-input-enhanced" value="{{ $stat->label }}" required>
                            </div>
                            <div class="col-12">
                                <div class="seo-options-panel mb-0">
                                    <div class="seo-option-item">
                                        <input class="form-check-input mt-1" type="checkbox" name="is_active" value="1" id="edit_stat_active_{{ $stat->id }}" @checked($stat->is_active)>
                                        <label class="form-check-label" for="edit_stat_active_{{ $stat->id }}">نشط</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary btn-wave">
                            <i class="ri-save-line me-1"></i> تحديث
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-admin.confirm-modal
        :id="'deleteStat' . $stat->id"
        title="تأكيد حذف الإحصائية"
        message="سيتم إزالة هذا العنصر من إحصائيات الصفحة الرئيسية."
        :subject="$stat->label"
        :subject-meta="'القيمة: ' . $stat->value"
        icon="ri-bar-chart-box-line"
        :action="route('admin.homepage.stats.destroy', $stat)"
        method="DELETE"
        confirm-text="نعم، احذف"
    />
@endforeach

{{-- Accreditations edit & delete modals --}}
@foreach($accreditations as $item)
    <div class="modal fade" id="editAccreditation{{ $item->id }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <form action="{{ route('admin.homepage.accreditations.update', $item) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-header">
                        <h5 class="modal-title fw-bold"><i class="ri-pencil-line me-1 text-primary"></i> تعديل الاعتماد</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="إغلاق"></button>
                    </div>
                    <div class="modal-body">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label fw-semibold">الاسم <span class="text-danger">*</span></label>
                                <input type="text" name="name" class="form-control form-input-enhanced" value="{{ $item->name }}" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">الأيقونة</label>
                                <input type="text" name="icon" class="form-control form-input-enhanced" value="{{ $item->icon }}" dir="ltr">
                            </div>
                            <div class="col-md-3">
                                <label class="form-label fw-semibold">الترتيب</label>
                                <input type="number" name="sort_order" class="form-control form-input-enhanced" value="{{ $item->sort_order }}" min="0">
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-semibold">الوصف</label>
                                <textarea name="description" class="form-control form-input-enhanced" rows="3">{{ $item->description }}</textarea>
                            </div>
                            <div class="col-12">
                                <div class="seo-options-panel mb-0">
                                    <div class="seo-option-item">
                                        <input class="form-check-input mt-1" type="checkbox" name="is_active" value="1" id="edit_acc_active_{{ $item->id }}" @checked($item->is_active)>
                                        <label class="form-check-label" for="edit_acc_active_{{ $item->id }}">نشط</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light border" data-bs-dismiss="modal">إلغاء</button>
                        <button type="submit" class="btn btn-primary btn-wave">
                            <i class="ri-save-line me-1"></i> تحديث
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <x-admin.confirm-modal
        :id="'deleteAccreditation' . $item->id"
        title="تأكيد حذف الاعتماد"
        message="سيتم إزالة هذا الاعتماد من الصفحة الرئيسية."
        :subject="$item->name"
        icon="ri-award-line"
        :action="route('admin.homepage.accreditations.destroy', $item)"
        method="DELETE"
        confirm-text="نعم، احذف"
    />
@endforeach
