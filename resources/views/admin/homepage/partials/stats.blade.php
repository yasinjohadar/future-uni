<div class="card custom-card data-table-card mb-4">
    <div class="card-header d-flex align-items-center justify-content-between flex-wrap gap-2">
        <div class="d-flex align-items-center gap-2">
            <span class="fw-bold fs-16"><i class="ri-bar-chart-box-line me-1 text-primary"></i> إحصائيات الصفحة</span>
            <span class="table-count-badge">{{ number_format($stats->count()) }}</span>
        </div>
        <button class="btn btn-primary btn-sm btn-wave" type="button" data-bs-toggle="collapse" data-bs-target="#addStat" aria-expanded="false">
            <i class="ri-add-line me-1"></i> إضافة
        </button>
    </div>

    <div class="collapse homepage-add-panel" id="addStat">
        <div class="homepage-add-panel__inner">
            <h6 class="fw-semibold mb-3"><i class="ri-add-circle-line me-1 text-primary"></i> إحصائية جديدة</h6>
            <form action="{{ route('admin.homepage.stats.store') }}" method="POST">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">الأيقونة</label>
                        <input type="text" name="icon" class="form-control form-input-enhanced" placeholder="ri-building-line" dir="ltr">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label fw-semibold">القيمة <span class="text-danger">*</span></label>
                        <input type="text" name="value" class="form-control form-input-enhanced" placeholder="85" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label fw-semibold">التسمية <span class="text-danger">*</span></label>
                        <input type="text" name="label" class="form-control form-input-enhanced" placeholder="برنامج أكاديمي" required>
                    </div>
                    <div class="col-md-2">
                        <label class="form-label fw-semibold">الترتيب</label>
                        <input type="number" name="sort_order" class="form-control form-input-enhanced" min="0">
                    </div>
                    <div class="col-12">
                        <div class="seo-options-panel mb-3">
                            <div class="seo-option-item">
                                <input class="form-check-input mt-1" type="checkbox" name="is_active" value="1" id="new_stat_active" checked>
                                <label class="form-check-label" for="new_stat_active">نشط</label>
                            </div>
                        </div>
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
                        <th style="min-width: 100px;">القيمة</th>
                        <th style="min-width: 200px;">التسمية</th>
                        <th style="min-width: 80px;">الترتيب</th>
                        <th style="min-width: 120px;">الحالة</th>
                        <th style="min-width: 120px;">إجراء</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($stats as $stat)
                        <tr>
                            <td class="text-muted fw-medium">{{ $loop->iteration }}</td>
                            <td>
                                <span class="fw-bold fs-16">{{ $stat->value }}</span>
                                @if($stat->icon)
                                    <span class="text-muted fs-12 d-block" dir="ltr"><i class="{{ $stat->icon }}"></i></span>
                                @endif
                            </td>
                            <td>{{ $stat->label }}</td>
                            <td><span class="badge-soft badge-soft-secondary">{{ $stat->sort_order }}</span></td>
                            <td>
                                <form action="{{ route('admin.homepage.stats.toggle-active', $stat) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit"
                                            class="activation-pill {{ $stat->is_active ? 'activation-pill--active' : 'activation-pill--inactive' }} mb-0">
                                        <i class="ri-shut-down-line"></i>
                                        <span class="toggle-label">{{ $stat->is_active ? 'نشط' : 'غير نشط' }}</span>
                                    </button>
                                </form>
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button"
                                            class="action-btn action-btn--edit"
                                            title="تعديل"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editStat{{ $stat->id }}">
                                        <i class="ri-pencil-line"></i>
                                    </button>
                                    <button type="button"
                                            class="action-btn action-btn--delete"
                                            title="حذف"
                                            data-bs-toggle="modal"
                                            data-bs-target="#deleteStat{{ $stat->id }}">
                                        <i class="ri-delete-bin-line"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <div class="empty-state">
                                    <div class="empty-state-icon"><i class="ri-bar-chart-box-line"></i></div>
                                    <h5 class="fw-bold mb-2">لا توجد إحصائيات</h5>
                                    <p class="text-muted mb-3">أضف أرقاماً تظهر في الصفحة الرئيسية.</p>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="collapse" data-bs-target="#addStat">
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
