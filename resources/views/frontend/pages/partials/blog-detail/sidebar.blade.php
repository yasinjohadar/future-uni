<div class="blog-detail-sidebar">
    <div class="blog-detail-panel section-fade-up">
        <h3 class="blog-detail-panel__title">فهرس المقال</h3>
        <nav class="blog-detail-toc" id="blogDetailToc"></nav>
    </div>

    @if($recentPosts->isNotEmpty())
    <div class="blog-detail-panel section-fade-up">
        <h3 class="blog-detail-panel__title">أخبار ذات صلة</h3>
        @foreach($recentPosts as $recent)
        <a href="{{ route('blog.show', $recent->slug) }}" class="blog-detail-related">
            <span class="blog-detail-related__thumb">
                <i class="{{ $recent->category?->icon ?? 'fas fa-newspaper' }}"></i>
            </span>
            <div>
                <div class="blog-detail-related__title">{{ $recent->title }}</div>
                @if($recent->published_at)
                <div class="blog-detail-related__date">
                    <i class="far fa-calendar-alt"></i>
                    {{ $recent->published_at->translatedFormat('d F Y') }}
                </div>
                @endif
            </div>
        </a>
        @endforeach
    </div>
    @endif

    @if($post->tags->isNotEmpty())
    <div class="blog-detail-panel section-fade-up">
        <h3 class="blog-detail-panel__title">الوسوم</h3>
        <div class="blog-detail-tag-cloud">
            @foreach($post->tags as $tag)
            <a href="{{ route('blog') }}" class="blog-detail-tag">{{ $tag->name }}</a>
            @endforeach
        </div>
    </div>
    @endif

    <div class="blog-detail-panel blog-detail-newsletter section-fade-up">
        <i class="fas fa-envelope-open-text fa-2x mb-3"></i>
        <h5 class="blog-detail-newsletter__title">اشترك في النشرة الإخبارية</h5>
        <p class="blog-detail-newsletter__desc">احصل على آخر أخبار الجامعة مباشرة في بريدك الإلكتروني.</p>
        <form action="{{ route('newsletter.subscribe') }}" method="POST">
            @csrf
            <input type="email" name="email" class="form-control mb-2 en-text" placeholder="بريدك الإلكتروني" required>
            <button type="submit" class="btn btn-accent w-100">اشترك الآن</button>
        </form>
    </div>
</div>
