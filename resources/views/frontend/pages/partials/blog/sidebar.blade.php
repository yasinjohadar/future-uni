<div class="blog-sidebar">
    <div class="sidebar-widget">
        <div class="glass-card blog-sidebar-card">
            <h5 class="sidebar-widget-title"><i class="fas fa-search ms-2"></i>ابحث في الأخبار</h5>
            <form action="{{ route('blog') }}" method="GET" class="blog-sidebar-search">
                @if($activeCategory ?? false)
                    <input type="hidden" name="category" value="{{ $activeCategory }}">
                @endif
                @if($activeTag ?? false)
                    <input type="hidden" name="tag" value="{{ $activeTag }}">
                @endif
                <div class="blog-sidebar-search__field">
                    <input type="text"
                           name="q"
                           class="form-control blog-sidebar-search__input"
                           placeholder="كلمة البحث..."
                           value="{{ $searchQuery ?? '' }}">
                    <button class="btn btn-accent blog-sidebar-search__btn" type="submit" aria-label="بحث">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(($stats['posts'] ?? 0) > 0)
        <div class="sidebar-widget">
            <div class="glass-card blog-sidebar-card blog-sidebar-stats">
                <div class="blog-sidebar-stat">
                    <span class="blog-sidebar-stat__icon"><i class="fas fa-newspaper"></i></span>
                    <div>
                        <strong class="blog-sidebar-stat__value en-text">{{ number_format($stats['posts']) }}</strong>
                        <span class="blog-sidebar-stat__label">مقال منشور</span>
                    </div>
                </div>
                <div class="blog-sidebar-stat">
                    <span class="blog-sidebar-stat__icon"><i class="fas fa-folder-open"></i></span>
                    <div>
                        <strong class="blog-sidebar-stat__value en-text">{{ number_format($stats['categories'] ?? 0) }}</strong>
                        <span class="blog-sidebar-stat__label">تصنيف</span>
                    </div>
                </div>
            </div>
        </div>
    @endif

    @if($categories->isNotEmpty())
        <div class="sidebar-widget">
            <div class="glass-card blog-sidebar-card">
                <h5 class="sidebar-widget-title"><i class="fas fa-tags ms-2"></i>التصنيفات</h5>
                <ul class="blog-sidebar-categories list-unstyled mb-0">
                    <li>
                        <a href="{{ route('blog', array_filter(['q' => $searchQuery ?? null, 'tag' => $activeTag ?? null])) }}"
                           class="blog-sidebar-category {{ empty($activeCategory) ? 'is-active' : '' }}">
                            <span class="blog-sidebar-category__label">
                                <i class="fas fa-layer-group text-accent"></i>
                                جميع الأخبار
                            </span>
                            <span class="blog-sidebar-category__count">{{ number_format($stats['posts'] ?? 0) }}</span>
                        </a>
                    </li>
                    @foreach($categories as $category)
                        <li>
                            <a href="{{ route('blog', array_filter(['category' => $category->slug, 'q' => $searchQuery ?? null, 'tag' => $activeTag ?? null])) }}"
                               class="blog-sidebar-category {{ ($activeCategory ?? '') === $category->slug ? 'is-active' : '' }}">
                                <span class="blog-sidebar-category__label">
                                    <i class="{{ college_fa_icon($category->icon, 'fa-folder') }} text-accent"></i>
                                    {{ $category->name }}
                                </span>
                                <span class="blog-sidebar-category__count">{{ number_format($category->published_posts_count ?? $category->posts_count ?? 0) }}</span>
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    @if($recentPosts->isNotEmpty())
        <div class="sidebar-widget">
            <div class="glass-card blog-sidebar-card">
                <h5 class="sidebar-widget-title"><i class="far fa-clock ms-2"></i>آخر الأخبار</h5>
                <div class="blog-sidebar-recent">
                    @foreach($recentPosts as $recent)
                        @php
                            $thumbStyle = $recent->category?->color
                                ? 'background:' . $recent->category->color . ';'
                                : 'background:#0F172A;';
                            $imageUrl = $recent->featured_image ? media_public_url($recent->featured_image) : null;
                        @endphp
                        <a href="{{ route('blog.show', $recent->slug) }}" class="related-news-item">
                            @if($imageUrl)
                                <div class="related-news-thumb related-news-thumb--image">
                                    <img src="{{ $imageUrl }}" alt="{{ $recent->title }}" loading="lazy">
                                </div>
                            @else
                                <div class="related-news-thumb" style="{{ $thumbStyle }}">
                                    <i class="{{ college_fa_icon($recent->category?->icon, 'fa-newspaper') }}"></i>
                                </div>
                            @endif
                            <div>
                                <div class="related-news-title">{{ $recent->title }}</div>
                                @if($recent->published_at)
                                    <div class="related-news-date">
                                        <i class="far fa-calendar-alt me-1"></i>
                                        {{ $recent->published_at->translatedFormat('d F Y') }}
                                    </div>
                                @endif
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    @if($popularTags->isNotEmpty())
        <div class="sidebar-widget">
            <div class="glass-card blog-sidebar-card">
                <h5 class="sidebar-widget-title"><i class="fas fa-hashtag ms-2"></i>الوسوم الشائعة</h5>
                <div class="blog-sidebar-tags">
                    @foreach($popularTags as $tag)
                        <a href="{{ route('blog', array_filter(['tag' => $tag->slug, 'category' => $activeCategory ?? null, 'q' => $searchQuery ?? null])) }}"
                           class="blog-sidebar-tag {{ ($activeTag ?? '') === $tag->slug ? 'is-active' : '' }}"
                           @if($tag->color) style="--tag-color: {{ $tag->color }};" @endif>
                            {{ $tag->name }}
                            <span class="blog-sidebar-tag__count">{{ $tag->posts_count }}</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    @endif

    <div class="sidebar-widget">
        <div class="glass-card blog-sidebar-card blog-sidebar-newsletter text-center">
            <span class="blog-sidebar-newsletter__icon"><i class="fas fa-envelope-open-text"></i></span>
            <h5 class="blog-sidebar-newsletter__title">النشرة الإخبارية</h5>
            <p class="blog-sidebar-newsletter__desc">اشترك ليصلك آخر أخبار الجامعة وفعالياتها الأكاديمية.</p>
            <form action="{{ route('newsletter.subscribe') }}" method="POST">
                @csrf
                <input type="email"
                       name="email"
                       class="form-control blog-sidebar-newsletter__input mb-2 en-text"
                       placeholder="بريدك الإلكتروني"
                       required>
                <button type="submit" class="btn btn-accent w-100">اشترك الآن</button>
            </form>
        </div>
    </div>
</div>
