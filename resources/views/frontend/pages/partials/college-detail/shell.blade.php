<main id="collegeDetailContent" data-ssr="1">
    @include('frontend.pages.partials.shared.page-hero', [
        'heroIcon' => 'fas ' . ($college->icon ?? 'fa-building-columns'),
        'heroTitle' => $college->name,
        'heroSubtitle' => Str::limit(strip_tags($college->description ?? ''), 160),
        'breadcrumbs' => [
            ['label' => 'الرئيسية', 'route' => 'home'],
            ['label' => 'الكليات', 'route' => 'colleges'],
            ['label' => $college->name],
        ],
    ])

    @include('frontend.pages.partials.college-detail.highlights')

    <section class="college-detail-section section-fade-up py-5">
        <div class="container">
            <div class="row g-4 g-xl-5">
                <div class="col-lg-8">
                    <div class="college-detail-panel section-fade-up">
                        <h3 class="college-detail-panel__title"><i class="fas fa-building-columns ms-2"></i>عن الكلية</h3>
                        <div class="blog-detail-content text-secondary">{!! $college->description !!}</div>
                    </div>

                    @if($college->vision)
                    <div class="college-detail-panel section-fade-up">
                        <h3 class="college-detail-panel__title"><i class="fas fa-eye ms-2"></i>الرؤية</h3>
                        <div class="blog-detail-content text-secondary mb-0">{!! $college->vision !!}</div>
                    </div>
                    @endif

                    @if($college->mission)
                    <div class="college-detail-panel section-fade-up">
                        <h3 class="college-detail-panel__title"><i class="fas fa-bullseye ms-2"></i>الرسالة</h3>
                        <div class="blog-detail-content text-secondary mb-0">{!! $college->mission !!}</div>
                    </div>
                    @endif

                    @if($college->departments->isNotEmpty())
                    <div id="college-departments" class="college-detail-panel section-fade-up">
                        <h3 class="college-detail-panel__title"><i class="fas fa-layer-group ms-2"></i>الأقسام الأكاديمية</h3>
                        <div class="row g-3">
                            @foreach($college->departments as $department)
                            <div class="col-md-6 col-lg-4">
                                <a href="{{ route('departments.show', [$college->slug, $department->slug]) }}" class="text-decoration-none">
                                    <article class="dept-card h-100">
                                        <div class="dept-card__icon"><i class="fas {{ $department->icon ?? 'fa-layer-group' }}"></i></div>
                                        <h3 class="dept-card__title">{{ $department->name }}</h3>
                                        <p class="dept-card__desc">{{ Str::limit(strip_tags($department->description ?? ''), 120) }}</p>
                                        <div class="dept-card__stats">
                                            <span><i class="fas fa-book"></i>{{ $department->programs_count }} برامج</span>
                                            <span><i class="fas fa-users"></i>{{ $department->faculty_count }} عضو تدريس</span>
                                        </div>
                                    </article>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($college->programs->isNotEmpty())
                    <div id="college-programs" class="college-detail-panel section-fade-up mb-0">
                        <h3 class="college-detail-panel__title"><i class="fas fa-book-open ms-2"></i>البرامج الأكاديمية</h3>
                        <div class="row g-3">
                            @foreach($college->programs as $program)
                            <div class="col-md-6">
                                <a href="{{ route('programs.show', $program->slug) }}" class="text-decoration-none">
                                    <article class="college-detail-program h-100">
                                        <span class="program-level-badge level-{{ $program->level->value }}">{{ $program->level_label }}</span>
                                        <h4 class="college-detail-program__title">{{ $program->name }}</h4>
                                        <p class="college-detail-program__desc">{{ Str::limit(strip_tags($program->description ?? ''), 100) }}</p>
                                        <span class="read-more-link">عرض التفاصيل <i class="fas fa-arrow-left"></i></span>
                                    </article>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    @include('frontend.pages.partials.college-detail.sidebar')
                </div>
            </div>
        </div>
    </section>

    <section class="college-detail-cta section-fade-up">
        <div class="container">
            <div class="college-detail-cta__inner">
                <div>
                    <h2 class="college-detail-cta__title">استكشف {{ $college->name }}</h2>
                    <p class="college-detail-cta__desc mb-0">تصفّح الأقسام والبرامج أو تواصل معنا للاستفسار عن القبول والتخصصات.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @if($college->departments->isNotEmpty())
                    <a href="#college-departments" class="btn btn-accent px-4">الأقسام <i class="fas fa-arrow-left ms-2"></i></a>
                    @endif
                    <a href="{{ route('programs') }}" class="btn btn-glass college-detail-cta__btn-outline">البرامج</a>
                    <a href="{{ route('admission') }}" class="btn btn-glass college-detail-cta__btn-outline">القبول</a>
                </div>
            </div>
        </div>
    </section>
</main>
