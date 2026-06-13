<section class="blog-detail-section">
    <div class="container">
        <div class="blog-detail-featured section-fade-up">
            @if($post->featured_image)
                <img src="{{ media_public_url($post->featured_image) }}"
                     alt="{{ $post->featured_image_alt ?: $post->title }}"
                     class="w-100"
                     style="display:block; max-height:380px; object-fit:cover;">
            @else
                <div class="blog-detail-featured__placeholder">
                    <i class="{{ $post->category?->icon ?? 'fas fa-newspaper' }}"></i>
                </div>
            @endif
        </div>

        <div class="row g-4 g-xl-5">
            <div class="col-lg-8">
                <article class="blog-detail-panel section-fade-up">
                    <div class="blog-detail-content">
                        @if($post->excerpt)
                            <p>{{ $post->excerpt }}</p>
                        @endif
                        {!! $post->content !!}
                    </div>

                    <hr class="blog-detail-divider">

                    <div class="blog-detail-footer">
                        @if($post->tags->isNotEmpty())
                        <div class="blog-detail-tags">
                            @foreach($post->tags as $tag)
                                <span class="blog-detail-tag">{{ $tag->name }}</span>
                            @endforeach
                        </div>
                        @endif
                        <div class="blog-detail-share">
                            <span class="blog-detail-share__label">شارك الخبر:</span>
                            <div class="blog-detail-share__buttons">
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(url()->current()) }}&text={{ urlencode($post->title) }}"
                                   class="blog-detail-share__btn twitter" target="_blank" rel="noopener" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                                   class="blog-detail-share__btn facebook" target="_blank" rel="noopener" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(url()->current()) }}"
                                   class="blog-detail-share__btn linkedin" target="_blank" rel="noopener" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                                <a href="https://wa.me/?text={{ urlencode($post->title . ' ' . url()->current()) }}"
                                   class="blog-detail-share__btn whatsapp" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                                <a href="#" class="blog-detail-share__btn copy-link" aria-label="Copy link" onclick="copyBlogLink(event)"><i class="fas fa-link"></i></a>
                            </div>
                        </div>
                    </div>
                </article>

                @if($post->author)
                <div class="blog-detail-panel section-fade-up">
                    <div class="blog-detail-author">
                        <div class="blog-detail-avatar en-text">
                            {{ collect(explode(' ', $post->author->name))->map(fn ($w) => mb_substr($w, 0, 1))->take(2)->implode('.') }}
                        </div>
                        <div>
                            <h5 class="blog-detail-author__name">{{ $post->author->name }}</h5>
                            <p class="staff-position mb-0">كاتب المقال</p>
                        </div>
                    </div>
                </div>
                @endif

                <div class="blog-detail-panel section-fade-up">
                    <h3 class="blog-detail-panel__title"><i class="far fa-comments ms-2"></i>التعليقات ({{ number_format($post->comments_count) }})</h3>

                    <div class="blog-detail-comment-form">
                        <h5 class="blog-detail-comment-form__title">أضف تعليقك</h5>
                        <form id="comment-form">
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label small">الاسم الكامل *</label>
                                    <input type="text" class="form-control" placeholder="أدخل اسمك" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label small">البريد الإلكتروني *</label>
                                    <input type="email" class="form-control en-text" placeholder="example@email.com" required>
                                </div>
                                <div class="col-12">
                                    <label class="form-label small">التعليق *</label>
                                    <textarea class="form-control" rows="4" placeholder="اكتب تعليقك هنا..." required></textarea>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="btn btn-accent px-5">إرسال التعليق <i class="fas fa-paper-plane ms-2"></i></button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                @if($prevPost || $nextPost)
                <div class="d-flex justify-content-between gap-3 flex-wrap section-fade-up">
                    @if($prevPost)
                    <a href="{{ route('blog.show', $prevPost->slug) }}" class="btn btn-glass btn-sm">
                        <i class="fas fa-chevron-right ms-1"></i> {{ Str::limit($prevPost->title, 40) }}
                    </a>
                    @else
                    <span></span>
                    @endif
                    @if($nextPost)
                    <a href="{{ route('blog.show', $nextPost->slug) }}" class="btn btn-glass btn-sm">
                        {{ Str::limit($nextPost->title, 40) }} <i class="fas fa-chevron-left me-1"></i>
                    </a>
                    @endif
                </div>
                @endif
            </div>

            <div class="col-lg-4">
                @include('frontend.pages.partials.blog-detail.sidebar')
            </div>
        </div>
    </div>
</section>
