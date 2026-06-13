<section class="py-5 section-fade-up">
    <div class="container py-4">
        <div class="row g-5">
            <div class="col-lg-8">
                @if(!empty($searchQuery) || !empty($activeCategory) || !empty($activeTag))
                    <div class="blog-active-filters glass-card rounded-4 p-3 mb-4 d-flex flex-wrap align-items-center gap-2">
                        <span class="text-secondary small me-1"><i class="fas fa-filter text-accent me-1"></i>تصفية نشطة:</span>
                        @if(!empty($searchQuery))
                            <span class="blog-filter-chip">بحث: {{ $searchQuery }}</span>
                        @endif
                        @if(!empty($activeCategory))
                            @php $activeCat = $categories->firstWhere('slug', $activeCategory); @endphp
                            @if($activeCat)
                                <span class="blog-filter-chip">{{ $activeCat->name }}</span>
                            @endif
                        @endif
                        @if(!empty($activeTag))
                            @php $activeTagModel = $popularTags->firstWhere('slug', $activeTag); @endphp
                            <span class="blog-filter-chip">#{{ $activeTagModel?->name ?? $activeTag }}</span>
                        @endif
                        <a href="{{ route('blog') }}" class="btn btn-glass btn-sm ms-auto">مسح الكل</a>
                    </div>
                @endif

                @if($featuredPost)
                    <div class="glass-card rounded-4 overflow-hidden mb-4">
                        <a href="{{ route('blog.show', $featuredPost->slug) }}" class="text-decoration-none">
                            <div class="row g-0">
                                <div class="col-md-5">
                                    @if($featuredPost->featured_image)
                                        <img src="{{ media_public_url($featuredPost->featured_image) }}" alt="{{ $featuredPost->title }}" class="w-100 h-100" style="min-height: 250px; object-fit: cover;">
                                    @else
                                        <div class="h-100 d-flex align-items-center justify-content-center" style="background: #0F172A; min-height: 250px;">
                                            <i class="fas fa-newspaper fa-4x text-white opacity-50"></i>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-7">
                                    <div class="p-4">
                                        @if($featuredPost->category)
                                            <span class="badge bg-white bg-opacity-10 text-accent px-2 py-1 mb-2">{{ $featuredPost->category->name }}</span>
                                        @endif
                                        <h3 class="fw-bold text-white mb-2" style="font-size: 1.2rem;">{{ $featuredPost->title }}</h3>
                                        @if($featuredPost->excerpt)
                                            <p class="text-secondary small mb-3">{{ Str::limit(strip_tags($featuredPost->excerpt), 160) }}</p>
                                        @endif
                                        @if($featuredPost->published_at)
                                            <div class="d-flex align-items-center gap-3 text-secondary small">
                                                <span><i class="far fa-calendar-alt text-accent me-1"></i>{{ $featuredPost->published_at->translatedFormat('d F Y') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

                <div class="row g-4">
                    @forelse($posts as $post)
                        <div class="col-md-6">
                            <a href="{{ route('blog.show', $post->slug) }}" class="text-decoration-none">
                                <div class="glass-card rounded-4 overflow-hidden h-100">
                                    @if($post->featured_image)
                                        <img src="{{ media_public_url($post->featured_image) }}" alt="{{ $post->title }}" class="w-100" style="height: 180px; object-fit: cover;">
                                    @else
                                        <div class="d-flex align-items-center justify-content-center" style="background: #0F172A; height: 180px;">
                                            <i class="fas fa-newspaper fa-3x text-white opacity-50"></i>
                                        </div>
                                    @endif
                                    <div class="p-4">
                                        @if($post->category)
                                            <span class="badge bg-white bg-opacity-10 text-accent px-2 py-1 mb-2">{{ $post->category->name }}</span>
                                        @endif
                                        <h4 class="fw-bold text-white mb-2" style="font-size: 1.05rem;">{{ $post->title }}</h4>
                                        @if($post->excerpt)
                                            <p class="text-secondary small mb-3">{{ Str::limit(strip_tags($post->excerpt), 120) }}</p>
                                        @endif
                                        @if($post->published_at)
                                            <div class="d-flex align-items-center gap-3 text-secondary small">
                                                <span><i class="far fa-calendar-alt text-accent me-1"></i>{{ $post->published_at->translatedFormat('d F Y') }}</span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </a>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="glass-card p-5 text-center">
                                <p class="text-secondary mb-0">لا توجد مقالات منشورة حالياً.</p>
                            </div>
                        </div>
                    @endforelse
                </div>

                @if($posts->hasPages())
                    {{ $posts->links('frontend.partials.pagination.blog') }}
                @endif
            </div>

            <div class="col-lg-4">
                @include('frontend.pages.partials.blog.sidebar')
            </div>
        </div>
    </div>
</section>
