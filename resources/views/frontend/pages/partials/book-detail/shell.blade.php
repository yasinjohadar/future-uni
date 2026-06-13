<main id="bookDetailContent">
    @include('frontend.pages.partials.shared.page-hero', [
        'heroIcon' => 'fas fa-book-open',
        'heroTitle' => $book->title,
        'heroSubtitle' => $book->author,
        'breadcrumbs' => [
            ['label' => 'الرئيسية', 'route' => 'home'],
            ['label' => 'المكتبة', 'route' => 'library'],
            ['label' => $book->category?->name ?? 'كتاب'],
        ],
    ])

    <section class="book-detail-highlights section-fade-up">
        <div class="container">
            <div class="book-detail-highlights__grid">
                <div class="book-detail-highlight">
                    <span class="book-detail-highlight__icon"><i class="fas fa-file-lines"></i></span>
                    <div>
                        <strong class="book-detail-highlight__value en-text">{{ $book->pages }}</strong>
                        <span class="book-detail-highlight__label">صفحة</span>
                    </div>
                </div>
                <div class="book-detail-highlight">
                    <span class="book-detail-highlight__icon"><i class="fas fa-calendar"></i></span>
                    <div>
                        <strong class="book-detail-highlight__value en-text">{{ $book->publication_year ?? '—' }}</strong>
                        <span class="book-detail-highlight__label">سنة النشر</span>
                    </div>
                </div>
                <div class="book-detail-highlight">
                    <span class="book-detail-highlight__icon"><i class="fas fa-star"></i></span>
                    <div>
                        <strong class="book-detail-highlight__value en-text">{{ number_format($book->rating, 1) }}/5</strong>
                        <span class="book-detail-highlight__label">التقييم</span>
                    </div>
                </div>
                <div class="book-detail-highlight">
                    <span class="book-detail-highlight__icon"><i class="fas fa-{{ $book->is_available ? 'check-circle' : 'times-circle' }}"></i></span>
                    <div>
                        <strong class="book-detail-highlight__value">{{ $book->is_available ? 'متوفر' : 'غير متوفر' }}</strong>
                        <span class="book-detail-highlight__label">
                            @if($book->is_available)
                                {{ $book->copies_available }} من {{ $book->copies_total }} نسخة
                            @else
                                جميع النسخ محجوزة
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="book-detail-section">
        <div class="container">
            <div class="row g-4 g-xl-5">
                <div class="col-lg-8">
                    <div class="book-detail-panel section-fade-up">
                        <h3 class="book-detail-panel__title"><i class="fas fa-info-circle ms-2"></i>وصف الكتاب</h3>
                        <p class="text-secondary mb-0" style="line-height: 1.9;">{{ $book->description }}</p>
                    </div>

                    @if(! empty($book->chapters))
                        <div class="book-detail-panel section-fade-up">
                            <h3 class="book-detail-panel__title"><i class="fas fa-list-ol ms-2"></i>فهرس المحتويات</h3>
                            <div class="book-detail-chapters">
                                @foreach($book->chapters as $index => $chapter)
                                    <div class="book-detail-chapter">
                                        <span class="book-detail-chapter__num">{{ $index + 1 }}</span>
                                        <span class="book-detail-chapter__title">{{ $chapter }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(! empty($book->tags))
                        <div class="book-detail-panel section-fade-up">
                            <h3 class="book-detail-panel__title"><i class="fas fa-tags ms-2"></i>الوسوم</h3>
                            <div class="d-flex flex-wrap gap-2">
                                @foreach($book->tags as $tag)
                                    <span class="book-detail-tag">{{ $tag }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    <div class="book-detail-sidebar">
                        <div class="book-detail-panel section-fade-up">
                            <div class="book-detail-cover" style="background-color: {{ $book->color ?? '#0F172A' }};">
                                <i class="fas {{ $book->icon ?? 'fa-book' }}"></i>
                            </div>
                            <div class="book-detail-rating">
                                <div class="book-detail-rating__stars">
                                    @for($i = 0; $i < 5; $i++)
                                        <i class="fas fa-star {{ $i < floor($book->rating) ? '' : 'empty' }}"></i>
                                    @endfor
                                </div>
                                <span class="book-detail-rating__score en-text">{{ number_format($book->rating, 1) }}/5</span>
                            </div>
                            <div class="text-center mb-0">
                                @if($book->is_available)
                                    <span class="availability-badge available">
                                        <i class="fas fa-check-circle"></i>
                                        متوفر ({{ $book->copies_available }} من {{ $book->copies_total }})
                                    </span>
                                @else
                                    <span class="availability-badge unavailable">
                                        <i class="fas fa-times-circle"></i>
                                        غير متوفر حالياً
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="book-detail-panel section-fade-up">
                            <h3 class="book-detail-panel__title"><i class="fas fa-circle-info ms-2"></i>معلومات الكتاب</h3>
                            @if($book->publisher)
                                <div class="book-detail-info-row">
                                    <span class="book-detail-info-row__label">الناشر</span>
                                    <span class="book-detail-info-row__value">{{ $book->publisher }}</span>
                                </div>
                            @endif
                            @if($book->edition)
                                <div class="book-detail-info-row">
                                    <span class="book-detail-info-row__label">الطبعة</span>
                                    <span class="book-detail-info-row__value">{{ $book->edition }}</span>
                                </div>
                            @endif
                            <div class="book-detail-info-row">
                                <span class="book-detail-info-row__label">عدد الصفحات</span>
                                <span class="book-detail-info-row__value">{{ $book->pages }}</span>
                            </div>
                            @if($book->language)
                                <div class="book-detail-info-row">
                                    <span class="book-detail-info-row__label">اللغة</span>
                                    <span class="book-detail-info-row__value">{{ $book->language }}</span>
                                </div>
                            @endif
                            @if($book->isbn)
                                <div class="book-detail-info-row">
                                    <span class="book-detail-info-row__label">ISBN</span>
                                    <span class="book-detail-info-row__value en-text">{{ $book->isbn }}</span>
                                </div>
                            @endif
                            @if($book->shelf_location)
                                <div class="book-detail-info-row">
                                    <span class="book-detail-info-row__label">الموقع</span>
                                    <span class="book-detail-info-row__value">{{ $book->shelf_location }}</span>
                                </div>
                            @endif
                            @if($book->category)
                                <div class="book-detail-info-row">
                                    <span class="book-detail-info-row__label">التصنيف</span>
                                    <span class="book-detail-info-row__value">{{ $book->category->name }}</span>
                                </div>
                            @endif
                        </div>

                        <div class="book-detail-panel book-detail-reserve section-fade-up">
                            <i class="fas fa-hand-holding-heart fa-2x mb-3"></i>
                            <h5 class="book-detail-reserve__title">حجز الكتاب</h5>
                            <p class="book-detail-reserve__desc">يمكنك حجز هذا الكتاب من المكتبة الجامعية.</p>
                            <a href="{{ route('contact') }}" class="btn btn-accent w-100 mb-2">طلب حجز</a>
                            <a href="{{ route('library') }}" class="btn btn-glass w-100 btn-sm">العودة للمكتبة</a>
                        </div>

                        <div class="book-detail-panel section-fade-up">
                            <h3 class="book-detail-panel__title"><i class="fas fa-book-open ms-2"></i>كتب ذات صلة</h3>
                            <div class="book-detail-related">
                                @forelse($relatedBooks as $related)
                                    <a href="{{ route('library.book.show', $related->slug) }}" class="book-detail-related__item">
                                        <div class="book-detail-related__thumb" style="background-color: {{ $related->color ?? '#0F172A' }};">
                                            <i class="fas {{ $related->icon ?? 'fa-book' }}"></i>
                                        </div>
                                        <div>
                                            <div class="book-detail-related__title">{{ $related->title }}</div>
                                            <div class="book-detail-related__author">{{ $related->author }}</div>
                                        </div>
                                    </a>
                                @empty
                                    <p class="text-secondary small mb-0">لا توجد كتب ذات صلة حالياً.</p>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>
