<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="page-hero-icon">
                <i class="{{ $post->category?->icon ?? 'fas fa-newspaper' }}"></i>
            </div>
            @if($post->category)
                <span class="blog-detail-category">{{ $post->category->name }}</span>
            @endif
            <h1 class="page-hero-title">{{ $post->title }}</h1>
            @if($post->author)
                <p class="page-hero-subtitle">بقلم {{ $post->author->name }}</p>
            @endif
            <div class="page-hero-breadcrumb">
                <a href="{{ route('home') }}">الرئيسية</a>
                <span class="sep"><i class="fas fa-chevron-left"></i></span>
                <a href="{{ route('blog') }}">الأخبار</a>
                <span class="sep"><i class="fas fa-chevron-left"></i></span>
                <span class="current">تفاصيل الخبر</span>
            </div>
        </div>
    </div>
</section>
