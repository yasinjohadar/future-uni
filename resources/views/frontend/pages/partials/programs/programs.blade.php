<section class="programs-section section-fade-up">
    <div class="container">
        <div class="section-head text-center mb-4">
            <span class="section-head__eyebrow">مساراتنا</span>
            <h2 class="section-head__title">استكشف البرامج الأكاديمية</h2>
            <p class="section-head__desc mx-auto mb-0" style="max-width: 520px;">اختر المستوى الدراسي المناسب وتعرّف على متطلبات القبول لكل برنامج.</p>
        </div>
        <div class="text-center mb-4 programs-filters">
            <ul class="nav filter-tabs justify-content-center gap-2 flex-wrap" id="program-filter-tabs">
                <li class="nav-item"><a class="nav-link active" href="#" data-filter="all">جميع البرامج</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-filter="bachelor">بكالوريوس</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-filter="master">ماجستير</a></li>
                <li class="nav-item"><a class="nav-link" href="#" data-filter="phd">دكتوراه</a></li>
            </ul>
        </div>
        <div class="row g-4" id="programs-container" data-ssr="1">
            @foreach($programs ?? [] as $program)
            <div class="col-md-6 col-lg-4 program-item" data-level="{{ $program->level->value }}">
                <a href="{{ route('programs.show', $program->slug) }}" class="text-decoration-none">
                    <article class="program-card h-100">
                        <div class="program-card__head">
                            <span class="program-level-badge level-{{ $program->level->value }}">{{ $program->level_label }}</span>
                            @if($program->duration)
                            <span class="program-card__duration"><i class="fas fa-clock"></i>{{ $program->duration }}</span>
                            @endif
                        </div>
                        <h3 class="program-card__title">{{ $program->name }}</h3>
                        <p class="program-card__desc">{{ Str::limit(strip_tags($program->description ?? ''), 120) }}</p>
                        <p class="program-card__college"><i class="fas fa-building-columns"></i>{{ $program->college?->name }}</p>
                        @if($program->requirements)
                        <div class="program-card__requirements">
                            <i class="fas fa-clipboard-list"></i>{{ Str::limit(strip_tags($program->requirements), 80) }}
                        </div>
                        @endif
                        <span class="read-more-link">عرض التفاصيل <i class="fas fa-arrow-left"></i></span>
                    </article>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
