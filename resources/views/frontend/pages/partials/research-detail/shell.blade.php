<main id="researchDetailContent" data-ssr="1">
    @include('frontend.pages.partials.shared.page-hero', [
        'heroIcon' => college_fa_icon($center->icon, 'fa-flask'),
        'heroTitle' => $center->name,
        'heroSubtitle' => Str::limit(strip_tags($center->description ?? ''), 160),
        'breadcrumbs' => [
            ['label' => 'الرئيسية', 'route' => 'home'],
            ['label' => 'البحث العلمي', 'route' => 'research'],
            ['label' => $center->name],
        ],
    ])

    <section class="research-detail-highlights section-fade-up">
        <div class="container">
            <div class="research-detail-highlights__grid">
                <div class="research-detail-highlight">
                    <span class="research-detail-highlight__icon"><i class="fas fa-folder-open"></i></span>
                    <div>
                        <strong class="research-detail-highlight__value en-text">{{ number_format($center->projects_count) }}</strong>
                        <span class="research-detail-highlight__label">مشروع بحثي</span>
                    </div>
                </div>
                <div class="research-detail-highlight">
                    <span class="research-detail-highlight__icon"><i class="fas fa-file-lines"></i></span>
                    <div>
                        <strong class="research-detail-highlight__value en-text">{{ number_format($center->publications_count) }}</strong>
                        <span class="research-detail-highlight__label">منشور علمي</span>
                    </div>
                </div>
                <div class="research-detail-highlight">
                    <span class="research-detail-highlight__icon"><i class="fas fa-users"></i></span>
                    <div>
                        <strong class="research-detail-highlight__value en-text">{{ number_format($center->statValue('researchers', 0)) }}</strong>
                        <span class="research-detail-highlight__label">باحث</span>
                    </div>
                </div>
                <div class="research-detail-highlight">
                    <span class="research-detail-highlight__icon"><i class="fas fa-calendar"></i></span>
                    <div>
                        <strong class="research-detail-highlight__value en-text">{{ $center->established ?? '—' }}</strong>
                        <span class="research-detail-highlight__label">سنة التأسيس</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="research-detail-section section-fade-up">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-8">
                    <article class="research-detail-panel">
                        <h2 class="research-detail-panel__title"><i class="fas fa-circle-info"></i> نبذة عن المركز</h2>
                        <div class="research-detail-panel__text blog-detail-content text-secondary">
                            {!! $center->long_description ?: nl2br(e(strip_tags($center->description ?? ''))) !!}
                        </div>
                        @if(! empty($center->focus_areas))
                            <div class="research-detail-tags">
                                @foreach($center->focus_areas as $area)
                                    <span class="research-detail-tag">{{ $area }}</span>
                                @endforeach
                            </div>
                        @endif
                    </article>

                    @if(! empty($center->active_projects))
                        <article class="research-detail-panel mt-4">
                            <h2 class="research-detail-panel__title"><i class="fas fa-flask"></i> المشاريع النشطة</h2>
                            <div class="research-detail-projects">
                                @foreach($center->active_projects as $project)
                                    @php $statusClass = ($project['status'] ?? '') === 'مكتمل' ? 'research-detail-project__status--done' : ''; @endphp
                                    <div class="research-detail-project">
                                        <span class="research-detail-project__title">{{ $project['title'] ?? '' }}</span>
                                        <span class="research-detail-project__status {{ $statusClass }}">{{ $project['status'] ?? '' }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @endif
                </div>

                <div class="col-lg-4">
                    <aside class="research-detail-sidebar">
                        <div class="research-detail-panel">
                            <h3 class="research-detail-panel__title"><i class="fas fa-address-card"></i> معلومات المركز</h3>
                            <div class="research-detail-info-row">
                                <span class="research-detail-info-row__label">المدير</span>
                                <span class="research-detail-info-row__value">{{ $center->directorDisplayName() }}</span>
                            </div>
                            <div class="research-detail-info-row">
                                <span class="research-detail-info-row__label">الكلية</span>
                                <span class="research-detail-info-row__value">{{ $center->collegeDisplayName() }}</span>
                            </div>
                            @if($center->email)
                                <div class="research-detail-info-row">
                                    <span class="research-detail-info-row__label">البريد</span>
                                    <span class="research-detail-info-row__value en-text" dir="ltr">{{ $center->email }}</span>
                                </div>
                            @endif
                            @if($center->phone)
                                <div class="research-detail-info-row">
                                    <span class="research-detail-info-row__label">الهاتف</span>
                                    <span class="research-detail-info-row__value en-text" dir="ltr">{{ $center->phone }}</span>
                                </div>
                            @endif
                            <div class="research-detail-info-row">
                                <span class="research-detail-info-row__label">المختبرات</span>
                                <span class="research-detail-info-row__value en-text">{{ number_format($center->statValue('labs', 0)) }}</span>
                            </div>
                            <div class="research-detail-info-row">
                                <span class="research-detail-info-row__label">المنح البحثية</span>
                                <span class="research-detail-info-row__value en-text">{{ number_format($center->statValue('grants', 0)) }}</span>
                            </div>
                        </div>

                        @if(! empty($center->partners))
                            <div class="research-detail-panel mt-4">
                                <h3 class="research-detail-panel__title"><i class="fas fa-handshake"></i> الشركاء</h3>
                                <ul class="research-detail-partners">
                                    @foreach($center->partners as $partner)
                                        <li><i class="fas fa-handshake"></i>{{ $partner }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if($relatedCenters->isNotEmpty())
                            <div class="research-detail-panel mt-4">
                                <h3 class="research-detail-panel__title"><i class="fas fa-link"></i> مراكز أخرى</h3>
                                <div class="research-detail-related-list">
                                    @foreach($relatedCenters as $related)
                                        <a href="{{ route('research.show', $related->slug) }}" class="research-detail-related">
                                            <span class="research-detail-related__icon">
                                                <i class="{{ college_fa_icon($related->icon, 'fa-flask') }}"></i>
                                            </span>
                                            <span class="research-detail-related__title">{{ $related->name }}</span>
                                            <i class="fas fa-arrow-left research-detail-related__arrow"></i>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <a href="{{ route('research') }}" class="btn btn-accent w-100 mt-3">
                            جميع مراكز البحث <i class="fas fa-arrow-left ms-2"></i>
                        </a>
                    </aside>
                </div>
            </div>
        </div>
    </section>
</main>
