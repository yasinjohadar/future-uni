<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table data-table mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="min-width: 240px;">الاسم</th>
                    <th style="min-width: 120px;">النوع</th>
                    <th style="min-width: 180px;">المنصب</th>
                    <th style="min-width: 160px;">الكلية</th>
                    <th style="min-width: 110px;">التفعيل</th>
                    <th style="min-width: 130px;">إجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staffMembers as $member)
                    @php $initial = mb_strtoupper(mb_substr($member->name, 0, 1)); @endphp
                    <tr>
                        <td class="text-muted fw-medium">{{ $staffMembers->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="row-avatar {{ $loop->even ? 'row-avatar--alt' : '' }}">
                                    @if($member->icon)
                                        <i class="{{ str_contains($member->icon, ' ') ? $member->icon : 'fas ' . $member->icon }} fs-14"></i>
                                    @else
                                        {{ $initial }}
                                    @endif
                                </span>
                                <div>
                                    <a href="{{ route('admin.people.staff.show', $member) }}"
                                       class="fw-bold row-title-link text-decoration-none d-block">
                                        {{ $member->name }}
                                    </a>
                                    @if($member->is_featured)
                                        <span class="badge-soft badge-soft-warning fs-11">
                                            <i class="ri-star-line me-1"></i>مميز
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td>
                            <span class="badge-soft badge-soft-primary">{{ $member->type?->label() }}</span>
                        </td>
                        <td>{{ $member->position ?: '—' }}</td>
                        <td>
                            @if($member->college)
                                <span class="badge-soft badge-soft-info">
                                    <i class="ri-building-2-line me-1"></i>{{ $member->college->name }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.people.staff.toggle-active', $member) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit"
                                        class="activation-pill {{ $member->is_active ? 'activation-pill--active' : 'activation-pill--inactive' }} mb-0"
                                        title="{{ $member->is_active ? 'إيقاف العضو' : 'تفعيل العضو' }}">
                                    <i class="ri-shut-down-line"></i>
                                    <span class="toggle-label">{{ $member->is_active ? 'نشط' : 'غير نشط' }}</span>
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="action-btn-group">
                                <a href="{{ route('admin.people.staff.show', $member) }}"
                                   class="action-btn action-btn--view" title="عرض">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <a href="{{ route('admin.people.staff.edit', $member) }}"
                                   class="action-btn action-btn--edit" title="تعديل">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                <button type="button"
                                        class="action-btn action-btn--delete"
                                        title="حذف"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteStaff{{ $member->id }}">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="ri-team-line"></i></div>
                                @if(request()->hasAny(['search', 'type', 'college_id', 'status']))
                                    <h5 class="fw-bold mb-2">لا توجد نتائج</h5>
                                    <p class="text-muted mb-3">لم يتم العثور على أعضاء مطابقين للبحث.</p>
                                    <button type="button" class="btn btn-light border btn-sm" data-ajax-reset>
                                        <i class="ri-refresh-line me-1"></i> إعادة تعيين
                                    </button>
                                @else
                                    <h5 class="fw-bold mb-2">لا يوجد أعضاء</h5>
                                    <p class="text-muted mb-3">ابدأ بإضافة أعضاء الهيئة والقيادة.</p>
                                    <a href="{{ route('admin.people.staff.create') }}" class="btn btn-primary btn-sm">
                                        <i class="ri-add-line me-1"></i> إضافة عضو
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($staffMembers->hasPages())
        <div class="card-footer border-top bg-transparent py-3 ajax-pagination">
            {{ $staffMembers->withQueryString()->links() }}
        </div>
    @endif
</div>
