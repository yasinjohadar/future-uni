<main class="department-detail-content" data-ssr="1">
    @include('frontend.pages.partials.shared.page-hero', [
        'heroIcon' => 'fas ' . ($department->icon ?? 'fa-layer-group'),
        'heroTitle' => $department->name,
        'heroSubtitle' => Str::limit(strip_tags($department->description ?? ''), 160),
        'breadcrumbs' => [
            ['label' => 'الرئيسية', 'route' => 'home'],
            ['label' => 'الكليات', 'route' => 'colleges'],
            ['label' => $college->name, 'url' => route('colleges.show', $college->slug)],
            ['label' => $department->name],
        ],
    ])

    @include('frontend.pages.partials.department-detail.highlights')

    <section class="college-detail-section section-fade-up py-5">
        <div class="container">
            <div class="row g-4 g-xl-5">
                <div class="col-lg-8">
                    <div class="college-detail-panel section-fade-up">
                        <h3 class="college-detail-panel__title"><i class="fas fa-circle-info ms-2"></i>عن القسم</h3>
                        <div class="blog-detail-content text-secondary">{!! $department->description !!}</div>
                    </div>

                    @if($department->programs->isNotEmpty())
                    <div id="dept-programs" class="college-detail-panel section-fade-up">
                        <h3 class="college-detail-panel__title"><i class="fas fa-book-open ms-2"></i>برامج القسم</h3>
                        <div class="row g-3">
                            @foreach($department->programs as $program)
                            <div class="col-md-6">
                                <a href="{{ route('programs.show', $program->slug) }}" class="text-decoration-none">
                                    <article class="college-detail-program h-100">
                                        <span class="program-level-badge level-{{ $program->level->value }}">{{ $program->level_label }}</span>
                                        <h4 class="college-detail-program__title">{{ $program->name }}</h4>
                                        <p class="college-detail-program__desc">{{ Str::limit(strip_tags($program->description ?? ''), 100) }}</p>
                                        @if($program->duration)
                                        <p class="small text-secondary mb-2"><i class="fas fa-clock ms-1 text-accent"></i> {{ $program->duration }}</p>
                                        @endif
                                        <span class="read-more-link">عرض التفاصيل <i class="fas fa-arrow-left"></i></span>
                                    </article>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($facultyMembers->isNotEmpty())
                    <div class="college-detail-panel section-fade-up mb-0">
                        <h3 class="college-detail-panel__title"><i class="fas fa-chalkboard-user ms-2"></i>أعضاء هيئة التدريس</h3>
                        <div class="row g-3">
                            @foreach($facultyMembers as $member)
                            <div class="col-md-6">
                                <a href="{{ route('staff.show', $member->slug) }}" class="text-decoration-none">
                                    <article class="faculty-card h-100" style="padding: 1rem;">
                                        <div class="faculty-card__avatar" style="width: 48px; height: 48px; font-size: 1.1rem; margin-bottom: 0.75rem;"><i class="fas {{ $member->icon ?? 'fa-user-tie' }}"></i></div>
                                        <h3 class="faculty-card__name" style="font-size: 0.95rem;">{{ $member->name }}</h3>
                                        @if($member->academic_title)
                                        <p class="faculty-card__title mb-1">{{ $member->academic_title }}</p>
                                        @endif
                                        @if($member->specialty)
                                        <span class="faculty-card__specialty">{{ Str::limit($member->specialty, 50) }}</span>
                                        @endif
                                    </article>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if($siblingDepartments->isNotEmpty())
                    <div class="college-detail-panel section-fade-up mb-0">
                        <h3 class="college-detail-panel__title"><i class="fas fa-layer-group ms-2"></i>أقسام أخرى في {{ $college->name }}</h3>
                        <div class="row g-3">
                            @foreach($siblingDepartments->take(6) as $sibling)
                            <div class="col-md-6 col-lg-4">
                                <a href="{{ route('departments.show', [$college->slug, $sibling->slug]) }}" class="text-decoration-none">
                                    <article class="dept-card h-100">
                                        <div class="dept-card__icon"><i class="fas {{ $sibling->icon ?? 'fa-layer-group' }}"></i></div>
                                        <h3 class="dept-card__title">{{ $sibling->name }}</h3>
                                        <p class="dept-card__desc">{{ Str::limit(strip_tags($sibling->description ?? ''), 80) }}</p>
                                    </article>
                                </a>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    @include('frontend.pages.partials.department-detail.sidebar')
                </div>
            </div>
        </div>
    </section>

    <section class="college-detail-cta section-fade-up">
        <div class="container">
            <div class="college-detail-cta__inner">
                <div>
                    <h2 class="college-detail-cta__title">استكشف {{ $department->name }}</h2>
                    <p class="college-detail-cta__desc mb-0">تعرّف على برامج القسم أو عد إلى {{ $college->name }} لاستكشاف المزيد.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    @if($department->programs->isNotEmpty())
                    <a href="#dept-programs" class="btn btn-accent px-4">البرامج <i class="fas fa-arrow-left ms-2"></i></a>
                    @endif
                    <a href="{{ route('colleges.show', $college->slug) }}" class="btn btn-glass college-detail-cta__btn-outline">الكلية</a>
                    <a href="{{ route('admission') }}" class="btn btn-glass college-detail-cta__btn-outline">القبول</a>
                </div>
            </div>
        </div>
    </section>
</main>
