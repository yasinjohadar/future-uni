<section class="library-section section-fade-up">
    <div class="container">
        <div class="section-head text-center mb-4">
            <span class="section-head__eyebrow">المجموعات</span>
            <h2 class="section-head__title">تصفح الكتب والمراجع</h2>
            <p class="section-head__desc mx-auto mb-0" style="max-width: 520px;">اختر التصنيف المناسب أو استخدم البحث للوصول السريع إلى المراجع الأكاديمية.</p>
        </div>
        <div class="text-center mb-4 library-filters">
            <ul class="nav filter-tabs justify-content-center gap-2 flex-wrap" id="library-filter-tabs">
                <li class="nav-item">
                    <a class="nav-link {{ ($activeCategory ?? 'all') === 'all' ? 'active' : '' }}" href="#" data-filter="all">جميع الكتب</a>
                </li>
                @foreach($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link {{ ($activeCategory ?? 'all') === $category->slug ? 'active' : '' }}"
                           href="#"
                           data-filter="{{ $category->slug }}">{{ $category->name }}</a>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="row g-4"
             id="library-container"
             data-ssr="1"
             data-search-url="{{ route('library.search') }}"
             style="transition: opacity 0.3s ease;">
            @include('frontend.pages.partials.library.books-grid', ['books' => $books])
        </div>
        <div class="text-center mt-5">
            <button class="btn btn-accent px-5 py-2 rounded-pill" id="load-more-books" style="display:none;">
                <i class="fas fa-plus ms-2"></i>عرض المزيد
            </button>
        </div>
    </div>
</section>
