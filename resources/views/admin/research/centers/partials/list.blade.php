<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table data-table mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="min-width: 240px;">المركز</th>
                    <th style="min-width: 160px;">الكلية</th>
                    <th style="min-width: 100px;">المشاريع</th>
                    <th style="min-width: 110px;">التفعيل</th>
                    <th style="min-width: 120px;">إجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($centers as $center)
                    <tr>
                        <td class="text-muted fw-medium">{{ $centers->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="row-avatar {{ $loop->even ? 'row-avatar--alt' : '' }}">
                                    <i class="{{ college_fa_icon($center->icon, 'fa-flask') }} fs-14"></i>
                                </span>
                                <div>
                                    <a href="{{ route('admin.research.centers.show', $center) }}" class="fw-bold row-title-link text-decoration-none d-block">{{ $center->name }}</a>
                                    <span class="text-muted fs-11" dir="ltr">{{ $center->slug }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($center->college)
                                <span class="badge-soft badge-soft-primary"><i class="ri-building-2-line me-1"></i>{{ $center->college->name }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-soft badge-soft-info"><i class="ri-folder-open-line me-1"></i>{{ number_format($center->projects_count) }}</span>
                        </td>
                        <td>
                            <form action="{{ route('admin.research.centers.toggle-active', $center) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="activation-pill {{ $center->is_active ? 'activation-pill--active' : 'activation-pill--inactive' }} mb-0">
                                    <i class="ri-shut-down-line"></i>
                                    <span class="toggle-label">{{ $center->is_active ? 'نشط' : 'غير نشط' }}</span>
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="action-btn-group">
                                <a href="{{ route('admin.research.centers.show', $center) }}" class="action-btn action-btn--view" title="عرض"><i class="ri-eye-line"></i></a>
                                <a href="{{ route('admin.research.centers.edit', $center) }}" class="action-btn action-btn--edit" title="تعديل"><i class="ri-pencil-line"></i></a>
                                <button type="button" class="action-btn action-btn--delete" title="حذف" data-bs-toggle="modal" data-bs-target="#deleteResearchCenter{{ $center->id }}"><i class="ri-delete-bin-line"></i></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="ri-flask-line"></i></div>
                                <h5 class="fw-bold mb-2">لا توجد مراكز</h5>
                                <p class="text-muted mb-3">لم يتم إنشاء أي مركز بحث بعد.</p>
                                <a href="{{ route('admin.research.centers.create') }}" class="btn btn-primary btn-sm"><i class="ri-add-line me-1"></i> إضافة مركز</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($centers->hasPages())
        <div class="card-footer border-top bg-transparent py-3 ajax-pagination">
            {{ $centers->withQueryString()->links() }}
        </div>
    @endif
</div>
