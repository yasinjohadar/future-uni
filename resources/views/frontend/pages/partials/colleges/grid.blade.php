<section class="colleges-section section-fade-up">
    <div class="container">
        <div class="section-head text-center mb-4">
            <span class="section-head__eyebrow">برامجنا</span>
            <h2 class="section-head__title">استكشف كليات الجامعة</h2>
            <p class="section-head__desc mx-auto mb-0" style="max-width: 520px;">اختر التصنيف المناسب لتصفح الكليات والأقسام والبرامج الأكاديمية.</p>
        </div>
        <div class="text-center mb-4 colleges-filters">
            <ul class="nav filter-tabs justify-content-center gap-2 flex-wrap" id="college-filter-tabs">
                <li class="nav-item"><a class="nav-link active" href="#" data-filter="all">جميع الكليات</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-filter="medical">العلوم الطبية</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-filter="engineering">الهندسة والتقنية</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-filter="business">الإدارة والإنسانية</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-filter="science">العلوم الأساسية</a></li>
            </ul>
        </div>
        <div class="row g-4" id="all-colleges-container" data-ssr="1" style="transition: opacity 0.3s ease;">
            @foreach($colleges ?? [] as $index => $college)
            <div class="col-md-6 col-lg-4 college-item" data-category="{{ $college->category }}">
                <a href="{{ route('colleges.show', $college->slug) }}" class="text-decoration-none">
                    <article class="college-card has-image h-100">
                        <div class="college-bg" style="background-image: url('{{ college_card_image($college, $index) }}');"></div>
                        <div class="college-scrim"></div>
                        <div class="college-card__body">
                            <div class="college-icon"><i class="{{ college_fa_icon($college->icon) }}"></i></div>
                            <h3 class="college-card__title">{{ $college->name }}</h3>
                            <p class="college-card__desc">{{ Str::limit(strip_tags($college->description ?? ''), 100) }}</p>
                            <div class="college-card__stats">
                                <span><i class="fas fa-layer-group"></i>{{ $college->departments_count }} أقسام</span>
                                <span><i class="fas fa-book"></i>{{ $college->programs_count }} برنامج</span>
                            </div>
                        </div>
                    </article>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
