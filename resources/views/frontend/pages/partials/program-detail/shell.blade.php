<main class="program-detail-content" data-ssr="1">
    @include('frontend.pages.partials.shared.page-hero', [
        'heroIcon' => 'fas fa-graduation-cap',
        'heroTitle' => $program->name,
        'heroSubtitle' => Str::limit(strip_tags($program->description ?? ''), 160),
        'breadcrumbs' => [
            ['label' => 'الرئيسية', 'route' => 'home'],
            ['label' => 'البرامج', 'route' => 'programs'],
            ['label' => $program->name],
        ],
    ])

    @include('frontend.pages.partials.program-detail.highlights')

    <section class="college-detail-section section-fade-up py-5">
        <div class="container">
            <div class="row g-4 g-xl-5">
                <div class="col-lg-8">
                    <div class="college-detail-panel section-fade-up">
                        <h3 class="college-detail-panel__title">
                            <i class="fas fa-book-open ms-2"></i>نبذة عن البرنامج
                            <span class="program-level-badge level-{{ $program->level->value }} ms-2">{{ $program->level_label }}</span>
                        </h3>
                        <div class="blog-detail-content text-secondary">{!! $program->description !!}</div>
                    </div>

                    @if($program->requirements)
                    <div id="program-requirements" class="college-detail-panel section-fade-up">
                        <h3 class="college-detail-panel__title"><i class="fas fa-clipboard-list ms-2"></i>متطلبات القبول</h3>
                        <div class="blog-detail-content text-secondary mb-0">{!! $program->requirements !!}</div>
                    </div>
                    @endif

                    @if(!empty($program->objectives))
                    <div class="college-detail-panel section-fade-up">
                        <h3 class="college-detail-panel__title"><i class="fas fa-bullseye ms-2"></i>أهداف البرنامج</h3>
                        <ul class="text-secondary mb-0" style="line-height: 1.9;">
                            @foreach($program->objectives as $objective)
                            <li>{{ $objective }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(!empty($program->careers))
                    <div class="college-detail-panel section-fade-up">
                        <h3 class="college-detail-panel__title"><i class="fas fa-briefcase ms-2"></i>فرص العمل</h3>
                        <ul class="text-secondary mb-0" style="line-height: 1.9;">
                            @foreach($program->careers as $career)
                            <li>{{ $career }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if($program->courses->isNotEmpty())
                    <div id="program-courses" class="college-detail-panel section-fade-up mb-0">
                        <h3 class="college-detail-panel__title"><i class="fas fa-list ms-2"></i>المقررات الدراسية</h3>
                        <div class="table-responsive">
                            <table class="table align-middle mb-0" style="--bs-table-bg: transparent;">
                                <thead>
                                    <tr style="border-bottom: 1px solid var(--glass-border);">
                                        <th class="text-secondary small">الرمز</th>
                                        <th class="text-secondary small">المقرر</th>
                                        <th class="text-secondary small">الساعات</th>
                                        <th class="text-secondary small">الفصل</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($program->courses as $course)
                                    <tr style="border-bottom: 1px solid var(--glass-border);">
                                        <td class="en-text">{{ $course->code }}</td>
                                        <td>{{ $course->name }}</td>
                                        <td class="en-text">{{ $course->credits }}</td>
                                        <td>{{ $course->semester ?? '—' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    @endif

                    @if($relatedPrograms->isNotEmpty())
                    <div class="college-detail-panel section-fade-up mb-0">
                        <h3 class="college-detail-panel__title"><i class="fas fa-layer-group ms-2"></i>برامج ذات صلة</h3>
                        <div class="row g-3">
                            @foreach($relatedPrograms as $related)
                            <div class="col-md-6">
                                <a href="{{ route('programs.show', $related->slug) }}" class="text-decoration-none">
                                    <article class="college-detail-program h-100">
                                        <span class="program-level-badge level-{{ $related->level->value }}">{{ $related->level_label }}</span>
                                        <h4 class="college-detail-program__title">{{ $related->name }}</h4>
                                        <p class="college-detail-program__desc">{{ Str::limit(strip_tags($related->description ?? ''), 80) }}</p>
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
                    @include('frontend.pages.partials.program-detail.sidebar')
                </div>
            </div>
        </div>
    </section>

    <section class="college-detail-cta section-fade-up">
        <div class="container">
            <div class="college-detail-cta__inner">
                <div>
                    <h2 class="college-detail-cta__title">ابدأ في {{ $program->name }}</h2>
                    <p class="college-detail-cta__desc mb-0">قدّم طلب القبول الآن أو تواصل مع فريق القبول للاستفسار عن المتطلبات والمواعيد.</p>
                </div>
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('admission') }}" class="btn btn-accent px-4">قدّم الآن <i class="fas fa-arrow-left ms-2"></i></a>
                    @if($program->college)
                    <a href="{{ route('colleges.show', $program->college->slug) }}" class="btn btn-glass college-detail-cta__btn-outline">الكلية</a>
                    @endif
                    <a href="{{ route('contact') }}" class="btn btn-glass college-detail-cta__btn-outline">تواصل</a>
                </div>
            </div>
        </div>
    </section>
</main>
