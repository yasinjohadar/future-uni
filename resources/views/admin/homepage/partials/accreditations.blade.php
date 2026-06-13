<div class="card custom-card data-table-card mb-0">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="fw-bold fs-16"><i class="ri-award-line me-1 text-primary"></i> الاعتمادات</span>
            <span class="table-count-badge">{{ number_format($accreditations->count()) }}</span>
        </div>
        <button class="btn btn-primary btn-sm btn-wave" type="button" data-bs-toggle="collapse" data-bs-target="#addAccreditation" aria-expanded="false">
            <i class="ri-add-line me-1"></i> إضافة
        </button>
    </div>

    <div class="collapse homepage-add-panel" id="addAccreditation">
        <div class="homepage-add-panel__inner">
            <h6 class="fw-semibold mb-3"><i class="ri-add-circle-line me-1 text-primary"></i> اعتماد جديد</h6>
            <form action="{{ route('admin.homepage.accreditations.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-5">
                        <label class="form-label fw-semibold">الاسم <span class="text-danger">*</span></label>
                        <input type="text" name="name" class="form-control form-input-enhanced" placeholder="ABET" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">الأيقونة</label>
                        <input type="text" name="icon" class="form-control form-input-enhanced" placeholder="ri-award-line" dir="ltr">
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">الترتيب</label>
                        <input type="number" name="sort_order" class="form-control form-input-enhanced" min="0">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <div class="seo-options-panel w-100 mb-0">
                            <div class="seo-option-item">
                                <input class="form-check-input mt-1" type="checkbox" name="is_active" value="1" id="new_acc_active" checked>
                                <label class="form-check-label" for="new_acc_active">نشط</label>
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <label class="form-label fw-semibold">الوصف</label>
                        <textarea name="description" class="form-control form-input-enhanced" rows="2"></textarea>
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-sm btn-wave">
                            <i class="ri-save-line me-1"></i> حفظ
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
                        <th style="min-width: 220px;">الاسم</th>
                        <th style="min-width: 80px;">الترتيب</th>
                        <th style="min-width: 120px;">الحالة</th>
                        <th style="min-width: 120px;">إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($accreditations as $item)
                        <tr>
                            <td class="text-muted fw-medium">{{ $loop->iteration }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($item->icon)
                                        <span class="row-avatar row-avatar--alt"><i class="{{ $item->icon }}"></i></span>
                                    @endif
                                    <div>
                                        <span class="fw-semibold">{{ $item->name }}</span>
                                        @if($item->description)
                                            <span class="text-muted fs-11 d-block">{{ \Illuminate\Support\Str::limit($item->description, 60) }}</span>
                                        @endif
                                    </div>
                                </div>
                            </td>
                            <td><span class="badge-soft badge-soft-secondary">{{ $item->sort_order }}</span></td>
                            <td>
                                <form action="{{ route('admin.homepage.accreditations.toggle-active', $item) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="activation-pill {{ $item->is_active ? 'activation-pill--active' : 'activation-pill--inactive' }} mb-0">
                                        <i class="ri-shut-down-line"></i>
                                        <span class="toggle-label">{{ $item->is_active ? 'نشط' : 'غير نشط' }}</span>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button"
                                            class="action-btn action-btn--edit"
                                            title="تعديل"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editAccreditation{{ $item->id }}">
                                        <i class="ri-pencil-line"></i>
                                    </button>
                                    <button type="button"
                                            class="action-btn action-btn--delete"
                                            title="حذف"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteAccreditation{{ $item->id }}">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="empty-state">
                                    <div class="empty-state-icon"><i class="ri-award-line"></i></div>
                                    <h5 class="fw-bold mb-2">لا توجد اعتمادات</h5>
                                    <p class="text-muted mb-3">أضف شهادات الاعتماد المعروضة في الموقع.</p>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#addAccreditation">
                                        <i class="ri-add-line me-1"></i> إضافة
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
