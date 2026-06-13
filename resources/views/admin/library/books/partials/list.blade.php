<div class="card-body p-0">
    <div class="table-responsive">
        <table class="table data-table mb-0">
            <thead>
                <tr>
                    <th style="width: 50px;">#</th>
                    <th style="min-width: 260px;">الكتاب</th>
                    <th style="min-width: 140px;">التصنيف</th>
                    <th style="min-width: 100px;">التوفر</th>
                    <th style="min-width: 110px;">التفعيل</th>
                    <th style="min-width: 120px;">إجراء</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                    <tr>
                        <td class="text-muted fw-medium">{{ $books->firstItem() + $loop->index }}</td>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <span class="row-avatar {{ $loop->even ? 'row-avatar--alt' : '' }}" @if($book->color) style="background: {{ $book->color }};" @endif>
                                    <i class="{{ college_fa_icon($book->icon, 'fa-book') }} fs-14"></i>
                                </span>
                                <div>
                                    <a href="{{ route('admin.library.books.show', $book) }}" class="fw-bold row-title-link text-decoration-none d-block">{{ $book->title }}</a>
                                    <span class="text-muted fs-11">{{ $book->author }}</span>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($book->category)
                                <span class="badge-soft badge-soft-primary">{{ $book->category->name }}</span>
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td>
                            @if($book->is_available)
                                <span class="badge-soft badge-soft-success">{{ $book->copies_available }}/{{ $book->copies_total }}</span>
                            @else
                                <span class="badge-soft badge-soft-secondary">غير متوفر</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('admin.library.books.toggle-active', $book) }}" method="POST" class="d-inline">
                                @csrf
                                <button type="submit" class="activation-pill {{ $book->is_active ? 'activation-pill--active' : 'activation-pill--inactive' }} mb-0">
                                    <i class="ri-shut-down-line"></i>
                                    <span class="toggle-label">{{ $book->is_active ? 'نشط' : 'غير نشط' }}</span>
                                </button>
                            </form>
                        </td>
                        <td>
                            <div class="action-btn-group">
                                <a href="{{ route('admin.library.books.show', $book) }}" class="action-btn action-btn--view" title="عرض"><i class="ri-eye-line"></i></a>
                                <a href="{{ route('admin.library.books.edit', $book) }}" class="action-btn action-btn--edit" title="تعديل"><i class="ri-pencil-line"></i></a>
                                <button type="button" class="action-btn action-btn--delete" title="حذف" data-bs-toggle="modal" data-bs-target="#deleteLibraryBook{{ $book->id }}"><i class="ri-delete-bin-line"></i></button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <div class="empty-state">
                                <div class="empty-state-icon"><i class="ri-book-line"></i></div>
                                <h5 class="fw-bold mb-2">لا توجد كتب</h5>
                                <a href="{{ route('admin.library.books.create') }}" class="btn btn-primary btn-sm"><i class="ri-add-line me-1"></i> إضافة كتاب</a>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($books->hasPages())
        <div class="card-footer border-top bg-transparent py-3 ajax-pagination">{{ $books->withQueryString()->links() }}</div>
    @endif
</div>
