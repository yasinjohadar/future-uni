<section class="research-pubs-section section-fade-up">
    <div class="container">
        <div class="section-head text-center mb-4">
            <span class="section-head__eyebrow">إنتاجنا العلمي</span>
            <h2 class="section-head__title">أحدث المنشورات العلمية</h2>
            <p class="section-head__desc mx-auto mb-0" style="max-width: 520px;">نماذج من أبحاث ومنشورات أعضاء هيئة التدريس والباحثين في الجامعة.</p>
        </div>
        <div class="row g-4">
            @forelse($latestPosts as $post)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none">
                        <article class="research-pub-card h-100">
                            <div class="research-pub-card__meta">
                                @if($post->category)
                                    <span class="research-pub-card__tag">{{ $post->category->name }}</span>
                                @endif
                                @if($post->published_at)
                                    <span class="research-pub-card__year en-text">{{ $post->published_at->format('Y') }}</span>
                                @endif
                            </div>
                            <h3 class="research-pub-card__title">{{ $post->title }}</h3>
                            @if($post->excerpt)
                                <p class="research-pub-card__desc">{{ Str::limit(strip_tags($post->excerpt), 120) }}</p>
                            @endif
                            <span class="read-more-link">عرض المنشور <i class="fas fa-arrow-left"></i></span>
                        </article>
                    </a>
                </div>
            @empty
                <div class="col-12">
                    <div class="text-center text-secondary py-4">
                        <p class="mb-3">لا توجد منشورات منشورة حالياً.</p>
                        <a href="{{ route('blog') }}" class="btn btn-glass btn-sm">تصفح الأخبار <i class="fas fa-arrow-left ms-2"></i></a>
                    </div>
                </div>
            @endforelse
        </div>
    </div>
</section>
