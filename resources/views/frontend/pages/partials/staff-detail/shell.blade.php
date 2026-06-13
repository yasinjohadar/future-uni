<main id="staffDetailContent" data-ssr="1">
    @include('frontend.pages.partials.shared.page-hero', [
        'heroIcon' => 'fas ' . ($member->icon ?? 'fa-user-tie'),
        'heroTitle' => $member->name,
        'heroSubtitle' => trim(($member->position ?? $member->academic_title ?? '') . ($member->college ? ' · ' . $member->college->name : '')),
        'breadcrumbs' => [
            ['label' => 'الرئيسية', 'route' => 'home'],
            ['label' => $member->type === \App\Enums\StaffType::Faculty ? 'هيئة التدريس' : 'الهيئة الإدارية', 'route' => $member->type === \App\Enums\StaffType::Faculty ? 'faculty' : 'staff'],
            ['label' => $member->name],
        ],
    ])

    @include('frontend.pages.partials.staff-detail.highlights')

    <section class="staff-detail-section">
        <div class="container">
            <div class="row g-4 g-xl-5">
                <div class="col-lg-8">
                    <div class="staff-detail-panel section-fade-up">
                        <h3 class="staff-detail-panel__title"><i class="fas fa-user ms-2"></i>نبذة تعريفية</h3>
                        <div class="blog-detail-content text-secondary mb-0">{!! $member->bio ?? '<p>لا توجد نبذة متاحة.</p>' !!}</div>
                    </div>

                    @if(!empty($member->education))
                    <div class="staff-detail-panel section-fade-up">
                        <h3 class="staff-detail-panel__title"><i class="fas fa-graduation-cap ms-2"></i>المؤهلات العلمية</h3>
                        <div class="about-timeline">
                            @foreach($member->education as $item)
                            <div class="about-timeline__item">
                                <span class="about-timeline__year">{{ $item['year'] ?? '' }}</span>
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $item['degree'] ?? '' }}</h6>
                                    <p class="text-secondary small mb-0"><i class="fas fa-university text-accent me-1"></i>{{ $item['institution'] ?? '' }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if(!empty($member->experience_history))
                    <div class="staff-detail-panel section-fade-up">
                        <h3 class="staff-detail-panel__title"><i class="fas fa-briefcase ms-2"></i>الخبرة المهنية</h3>
                        <div class="about-timeline">
                            @foreach($member->experience_history as $item)
                            <div class="about-timeline__item">
                                <span class="about-timeline__year en-text">{{ $item['year'] ?? '' }}</span>
                                <div>
                                    <h6 class="fw-bold mb-1">{{ $item['role'] ?? '' }}</h6>
                                    <p class="text-secondary small mb-0">{{ $item['desc'] ?? '' }}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                    @endif

                    @if(!empty($member->publications))
                    <div class="staff-detail-panel section-fade-up">
                        <h3 class="staff-detail-panel__title"><i class="fas fa-book ms-2"></i>أبرز المنشورات</h3>
                        @foreach($member->publications as $pub)
                        <div class="staff-detail-pub">
                            <div class="staff-detail-pub__title">{{ $pub['title'] ?? '' }}</div>
                            @if(!empty($pub['journal']))
                            <div class="staff-detail-pub__journal"><i class="fas fa-book ms-1"></i>{{ $pub['journal'] }}</div>
                            @endif
                            @if(!empty($pub['year']))
                            <div class="staff-detail-pub__year"><i class="far fa-calendar-alt ms-1"></i>{{ $pub['year'] }}</div>
                            @endif
                        </div>
                        @endforeach
                    </div>
                    @endif

                    @if(!empty($member->awards))
                    <div class="staff-detail-panel section-fade-up mb-0">
                        <h3 class="staff-detail-panel__title"><i class="fas fa-trophy ms-2"></i>الجوائز والتكريمات</h3>
                        @foreach($member->awards as $award)
                        <div class="staff-detail-award">
                            <i class="fas fa-award"></i>
                            <span>{{ is_array($award) ? ($award['title'] ?? '') : $award }}</span>
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>

                <div class="col-lg-4">
                    @include('frontend.pages.partials.staff-detail.sidebar')
                </div>
            </div>
        </div>
    </section>

    @if($relatedMembers->isNotEmpty())
    <section class="college-detail-cta section-fade-up">
        <div class="container">
            <div class="staff-detail-panel mb-4">
                <h3 class="staff-detail-panel__title"><i class="fas fa-users ms-2"></i>أعضاء ذوو صلة</h3>
                <div class="row g-3">
                    @foreach($relatedMembers as $related)
                    <div class="col-md-6 col-lg-4">
                        <a href="{{ route('staff.show', $related->slug) }}" class="text-decoration-none">
                            <article class="faculty-card h-100">
                                <div class="faculty-card__avatar"><i class="fas {{ $related->icon ?? 'fa-user-tie' }}"></i></div>
                                <h3 class="faculty-card__name">{{ $related->name }}</h3>
                                <p class="faculty-card__title">{{ $related->position ?? $related->academic_title }}</p>
                                @if($related->college)
                                <p class="faculty-card__college"><i class="fas fa-building-columns ms-1"></i>{{ $related->college->name }}</p>
                                @endif
                            </article>
                        </a>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif
</main>
