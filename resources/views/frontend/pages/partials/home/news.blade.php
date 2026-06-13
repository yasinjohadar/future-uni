        <!-- News Section -->
        <section class="home-news-section py-5 section-fade-up">
            <div class="container py-4">
                <div class="section-head d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4 mb-md-5">
                    <div>
                        <span class="section-head__eyebrow">آخر المستجدات</span>
                        <h2 class="section-head__title">أخبار الجامعة</h2>
                    </div>
                    <div class="home-news-head__actions d-flex align-items-center gap-2 gap-md-3">
                        <div class="home-news-nav home-carousel-nav d-flex gap-2">
                            <button type="button" class="home-carousel-nav__btn news-prev" aria-label="الخبر السابق"><i class="fas fa-chevron-right"></i></button>
                            <button type="button" class="home-carousel-nav__btn news-next" aria-label="الخبر التالي"><i class="fas fa-chevron-left"></i></button>
                        </div>
                        <a href="{{ route('blog') }}" class="btn btn-glass home-news-all-btn d-none d-md-inline-flex">جميع الأخبار <i class="fas fa-arrow-left ms-2"></i></a>
                    </div>
                </div>

                <div class="home-news-slider">
                    <div class="swiper news-swiper">
                        <div class="swiper-wrapper">
                            @forelse($blogPosts as $post)
                                @php
                                    $publishedAt = $post->published_at;
                                    $thumbClass = 'news-thumb--' . (($loop->iteration - 1) % 4 + 1);
                                    $imageUrl = $post->featured_image ? media_public_url($post->featured_image) : null;
                                @endphp
                                <div class="swiper-slide">
                                    <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none">
                                        <article class="uni-card uni-card--news h-100">
                                            <div class="news-image">
                                                @if($publishedAt)
                                                    <span class="news-date-badge">
                                                        <span class="day">{{ $publishedAt->format('d') }}</span>
                                                        <span class="month">{{ $publishedAt->translatedFormat('F') }}</span>
                                                    </span>
                                                @endif
                                                @if($imageUrl)
                                                    <img src="{{ $imageUrl }}" alt="{{ $post->featured_image_alt ?: $post->title }}" class="news-thumb" style="object-fit: cover;" loading="lazy">
                                                @else
                                                    <div class="news-thumb {{ $thumbClass }}">
                                                        <i class="fas fa-newspaper"></i>
                                                    </div>
                                                @endif
                                            </div>
                                            <div class="news-body">
                                                @if($post->category)
                                                    <span class="category-badge">{{ $post->category->name }}</span>
                                                @endif
                                                <h3 class="blog-title">{{ $post->title }}</h3>
                                                @if($post->excerpt)
                                                    <p class="text-secondary small mb-4">{{ Str::limit(strip_tags($post->excerpt), 120) }}</p>
                                                @endif
                                                <span class="read-more-link">اقرأ المزيد <i class="fas fa-arrow-left"></i></span>
                                            </div>
                                        </article>
                                    </a>
                                </div>
                            @empty
                                <div class="swiper-slide">
                                    <article class="uni-card uni-card--news h-100">
                                        <div class="news-image">
                                            <div class="news-thumb news-thumb--1">
                                                <i class="fas fa-newspaper"></i>
                                            </div>
                                        </div>
                                        <div class="news-body">
                                            <span class="category-badge">أخبار</span>
                                            <h3 class="blog-title">تابع آخر أخبار جامعة المستقبل</h3>
                                            <p class="text-secondary small mb-4">سيتم نشر الأخبار والفعاليات قريباً. تابعنا للاطلاع على المستجدات.</p>
                                            <a href="{{ route('blog') }}" class="read-more-link">جميع الأخبار <i class="fas fa-arrow-left"></i></a>
                                        </div>
                                    </article>
                                </div>
                            @endforelse
                        </div>

                        <div class="swiper-pagination news-pagination"></div>
                    </div>
                </div>

                <div class="text-center mt-4 d-md-none">
                    <a href="{{ route('blog') }}" class="btn btn-glass home-news-all-btn">جميع الأخبار <i class="fas fa-arrow-left ms-2"></i></a>
                </div>
            </div>
        </section>
