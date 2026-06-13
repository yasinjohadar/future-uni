<section class="blog-detail-highlights section-fade-up">
    <div class="container">
        <div class="blog-detail-highlights__grid">
            <div class="blog-detail-highlight">
                <span class="blog-detail-highlight__icon"><i class="far fa-calendar-alt"></i></span>
                <div>
                    <strong class="blog-detail-highlight__value">
                        {{ $post->published_at?->translatedFormat('d F Y') ?? '—' }}
                    </strong>
                    <span class="blog-detail-highlight__label">تاريخ النشر</span>
                </div>
            </div>
            <div class="blog-detail-highlight">
                <span class="blog-detail-highlight__icon"><i class="far fa-clock"></i></span>
                <div>
                    <strong class="blog-detail-highlight__value en-text">{{ $post->reading_time ?: '5' }}</strong>
                    <span class="blog-detail-highlight__label">دقائق قراءة</span>
                </div>
            </div>
            <div class="blog-detail-highlight">
                <span class="blog-detail-highlight__icon"><i class="far fa-eye"></i></span>
                <div>
                    <strong class="blog-detail-highlight__value en-text">{{ number_format($post->views_count) }}</strong>
                    <span class="blog-detail-highlight__label">مشاهدة</span>
                </div>
            </div>
            <div class="blog-detail-highlight">
                <span class="blog-detail-highlight__icon"><i class="far fa-comment"></i></span>
                <div>
                    <strong class="blog-detail-highlight__value en-text">{{ number_format($post->comments_count) }}</strong>
                    <span class="blog-detail-highlight__label">تعليق</span>
                </div>
            </div>
        </div>
    </div>
</section>
