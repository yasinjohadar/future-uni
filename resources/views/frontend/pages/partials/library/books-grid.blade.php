@forelse($books as $book)
    <div class="col-md-6 col-lg-4 col-xl-3">
        <a href="{{ route('library.book.show', $book->slug) }}" class="text-decoration-none">
            <div class="glass-card book-card h-100">
                <div class="book-cover" style="background-color: {{ $book->color ?? '#0F172A' }};">
                    <i class="fas {{ $book->icon ?? 'fa-book' }}"></i>
                    @if($book->category)
                        <span class="book-category-badge">{{ $book->category->name }}</span>
                    @endif
                </div>
                <div class="p-3">
                    <h6 class="fw-bold mb-1 book-title">{{ $book->title }}</h6>
                    <p class="text-secondary small mb-2"><i class="fas fa-user-pen text-accent me-1"></i>{{ $book->author }}</p>
                    <div class="d-flex align-items-center gap-2 mb-2">
                        <div class="d-flex gap-1">
                            @for($i = 0; $i < 5; $i++)
                                <i class="fas fa-star {{ $i < floor($book->rating) ? '' : 'empty' }}"
                                   style="color:{{ $i < floor($book->rating) ? '#fbbf24' : 'var(--text-secondary)' }};font-size:0.75rem;opacity:{{ $i < floor($book->rating) ? '1' : '0.3' }};"></i>
                            @endfor
                        </div>
                        <span class="text-secondary small" style="font-size:0.7rem;">{{ number_format($book->rating, 1) }}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-secondary small"><i class="fas fa-file-lines text-accent me-1"></i>{{ $book->pages }} صفحة</span>
                        <span class="availability-dot {{ $book->is_available ? 'available' : 'unavailable' }}"></span>
                    </div>
                </div>
            </div>
        </a>
    </div>
@empty
    <div class="col-12 text-center py-5">
        <i class="fas fa-book-open fa-3x text-secondary mb-3"></i>
        <p class="text-secondary">لا توجد نتائج مطابقة.</p>
    </div>
@endforelse
