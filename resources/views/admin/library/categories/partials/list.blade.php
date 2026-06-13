<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table data-table mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="min-width: 220px;">التصنيف</th>
                    <th style="min-width: 100px;">الكتب</th>
                    <th style="min-width: 80px;">الترتيب</th>
                    <th style="min-width: 110px;">التفعيل</th>
                    <th style="min-width: 120px;">إجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $category)
                    <tr>
                        <td class="text-muted fw-medium">{{ $categories->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="row-avatar {{ $loop->even ? 'row-avatar--alt' : '' }}" @if($category->color) style="background: {{ $category->color }};" @endif>
                                    <i class="{{ college_fa_icon($category->icon, 'fa-book') }} fs-14"></i>
                                </span>
                                <div>
                                    <a href="{{ route('admin.library.categories.edit', $category) }}" class="fw-bold row-title-link text-decoration-none d-block">{{ $category->name }}</a>
                                    <span class="text-muted fs-11" dir="ltr">{{ $category->slug }}</span>
                                </div>
                            </div>
                        </td>
                        <td><span class="badge-soft badge-soft-info">{{ number_format($category->books_count) }}</span></td>
                        <td>{{ $category->sort_order }}</td>
                        <td>
                            <form action="{{ route('admin.library.categories.toggle-active', $category) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="activation-pill {{ $category->is_active ? 'activation-pill--active' : 'activation-pill--inactive' }} mb-0">
                                    <i class="ri-shut-down-line"></i>
                                    <span class="toggle-label">{{ $category->is_active ? 'نشط' : 'غير نشط' }}</span>
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="action-btn-group">
                                <a href="{{ route('admin.library.categories.edit', $category) }}" class="action-btn action-btn--edit" title="تعديل"><i class="ri-pencil-line"></i></a>
                                <button type="button" class="action-btn action-btn--delete" title="حذف" data-bs-toggle="modal" data-bs-target="#deleteLibraryCategory{{ $category->id }}"><i class="ri-delete-bin-line"></i></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="ri-folder-line"></i></div>
                                <h5 class="fw-bold mb-2">لا توجد تصنيفات</h5>
                                <a href="{{ route('admin.library.categories.create') }}" class="btn btn-primary btn-sm"><i class="ri-add-line me-1"></i> إضافة تصنيف</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($categories->hasPages())
        <div class="card-footer border-top bg-transparent py-3 ajax-pagination">{{ $categories->withQueryString()->links() }}</div>
    @endif
</div>
