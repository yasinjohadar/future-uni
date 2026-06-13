<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table data-table mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="min-width: 220px;">الكلية</th>
                    <th style="min-width: 130px;">التصنيف</th>
                    <th style="min-width: 90px;">الأقسام</th>
                    <th style="min-width: 90px;">البرامج</th>
                    <th style="min-width: 110px;">التفعيل</th>
                    <th style="min-width: 120px;">إجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($colleges as $college)
                    @php
                        $initial = mb_strtoupper(mb_substr($college->name, 0, 1));
                        $categoryLabels = [
                            'engineering' => 'الهندسة والتقنية',
                            'medical' => 'العلوم الطبية',
                            'business' => 'الإدارة والإنسانية',
                            'science' => 'العلوم الأساسية',
                        ];
                    @endphp
                    <tr>
                        <td class="text-muted fw-medium">{{ $colleges->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="row-avatar {{ $loop->even ? 'row-avatar--alt' : '' }}">
                                    @if($college->icon)
                                        <i class="fas {{ $college->icon }} fs-14"></i>
                                    @else
                                        {{ $initial }}
                                    @endif
                                </span>
                                <div>
                                    <a href="{{ route('admin.academic.colleges.show', $college) }}"
                                       class="fw-bold row-title-link text-decoration-none d-block">
                                        {{ $college->name }}
                                    </a>
                                    <span class="text-muted fs-11" dir="ltr">{{ $college->slug }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($college->category)
                                <span class="badge-soft badge-soft-primary">
                                    {{ $categoryLabels[$college->category] ?? $college->category }}
                                </span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            <span class="badge-soft badge-soft-info">
                                <i class="ri-organization-chart me-1"></i>{{ number_format($college->departments_count) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge-soft badge-soft-secondary">
                                <i class="ri-book-open-line me-1"></i>{{ number_format($college->programs_count) }}
                            </span>
                        </td>
                        <td>
                            <form action="{{ route('admin.academic.colleges.toggle-active', $college) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit"
                                        class="activation-pill {{ $college->is_active ? 'activation-pill--active' : 'activation-pill--inactive' }} mb-0"
                                        title="{{ $college->is_active ? 'إيقاف الكلية' : 'تفعيل الكلية' }}">
                                    <i class="ri-shut-down-line"></i>
                                    <span class="toggle-label">{{ $college->is_active ? 'نشط' : 'غير نشط' }}</span>
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="action-btn-group">
                                <a href="{{ route('admin.academic.colleges.show', $college) }}"
                                   class="action-btn action-btn--view" title="عرض">
                                    <i class="ri-eye-line"></i>
                                </a>
                                <a href="{{ route('admin.academic.colleges.edit', $college) }}"
                                   class="action-btn action-btn--edit" title="تعديل">
                                    <i class="ri-pencil-line"></i>
                                </a>
                                <button type="button"
                                        class="action-btn action-btn--delete"
                                        title="حذف"
                                        data-bs-toggle="modal"
                                        data-bs-target="#deleteCollege{{ $college->id }}">
                                    <i class="ri-delete-bin-line"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="ri-building-2-line"></i></div>
                                @if(request()->hasAny(['search', 'status']))
                                    <h5 class="fw-bold mb-2">لا توجد نتائج</h5>
                                    <p class="text-muted mb-3">لم يتم العثور على كليات مطابقة للبحث.</p>
                                    <a href="{{ route('admin.academic.colleges.index') }}" class="btn btn-light border btn-sm">
                                        <i class="ri-refresh-line me-1"></i> إعادة تعيين
                                    </a>
                                @else
                                    <h5 class="fw-bold mb-2">لا توجد كليات</h5>
                                    <p class="text-muted mb-3">لم يتم إنشاء أي كلية بعد.</p>
                                    <a href="{{ route('admin.academic.colleges.create') }}" class="btn btn-primary btn-sm">
                                        <i class="ri-add-line me-1"></i> إضافة كلية
                                    </a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($colleges->hasPages())
        <div class="card-footer border-top bg-transparent py-3 ajax-pagination">
            {{ $colleges->withQueryString()->links() }}
        </div>
    @endif
</div>
