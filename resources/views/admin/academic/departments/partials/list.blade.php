<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table data-table mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="min-width: 220px;">القسم</th>
                    <th style="min-width: 180px;">الكلية</th>
                    <th style="min-width: 90px;">البرامج</th>
                    <th style="min-width: 110px;">التفعيل</th>
                    <th style="min-width: 120px;">إجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($departments as $department)
                    @php $initial = mb_strtoupper(mb_substr($department->name, 0, 1)); @endphp
                    <tr>
                        <td class="text-muted fw-medium">{{ $departments->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="row-avatar {{ $loop->even ? 'row-avatar--alt' : '' }}">
                                    @if($department->icon)
                                        <i class="fas {{ $department->icon }} fs-14"></i>
                                    @else
                                        {{ $initial }}
                                    @endif
                                </span>
                                <div>
                                    <a href="{{ route('admin.academic.departments.show', $department) }}"
                                       class="fw-bold row-title-link text-decoration-none d-block">
                                        {{ $department->name }}
                                    </a>
                                    <span class="text-muted fs-11" dir="ltr">{{ $department->slug }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($department->college)
                                <span class="badge-soft badge-soft-primary">
                                    <i class="ri-building-2-line me-1"></i>{{ $department->college->name }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-soft badge-soft-info">
                                <i class="ri-book-open-line me-1"></i>{{ number_format($department->programs_count) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.academic.departments.toggle-active', $department) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit"
                                        class="activation-pill {{ $department->is_active ? 'activation-pill--active' : 'activation-pill--inactive' }} mb-0"
                                        title="{{ $department->is_active ? 'إيقاف القسم' : 'تفعيل القسم' }}">
                                    <i class="ri-shut-down-line"></i>
                                    <span class="toggle-label">{{ $department->is_active ? 'نشط' : 'غير نشط' }}</span>
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="action-btn-group">
                                <a href="{{ route('admin.academic.departments.show', $department) }}"
                                   class="action-btn action-btn--view" title="عرض">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <a href="{{ route('admin.academic.departments.edit', $department) }}"
                                   class="action-btn action-btn--edit" title="تعديل">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                <button type="button"
                                        class="action-btn action-btn--delete"
                                        title="حذف"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteDepartment{{ $department->id }}">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="ri-node-tree"></i></div>
                                @if(request()->hasAny(['search', 'college_id', 'status']))
                                    <h5 class="fw-bold mb-2">لا توجد نتائج</h5>
                                    <p class="text-muted mb-3">لم يتم العثور على أقسام مطابقة للبحث.</p>
                                    <button type="button" class="btn btn-light border btn-sm" data-ajax-reset>
                                        <i class="ri-refresh-line me-1"></i> إعادة تعيين
                                    </button>
                                @else
                                    <h5 class="fw-bold mb-2">لا توجد أقسام</h5>
                                    <p class="text-muted mb-3">لم يتم إنشاء أي قسم بعد.</p>
                                    <a href="{{ route('admin.academic.departments.create', request()->only('college_id')) }}" class="btn btn-primary btn-sm">
                                        <i class="ri-add-line me-1"></i> إضافة قسم
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($departments->hasPages())
        <div class="card-footer border-top bg-transparent py-3 ajax-pagination">
            {{ $departments->withQueryString()->links() }}
        </div>
    @endif
</div>
