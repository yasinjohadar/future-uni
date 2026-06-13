<section class="research-section section-fade-up">
    <div class="container">
        <div class="section-head text-center mb-4">
            <span class="section-head__eyebrow">مراكزنا</span>
            <h2 class="section-head__title">مراكز الأبحاث</h2>
            <p class="section-head__desc mx-auto mb-0" style="max-width: 520px;">وحدات بحثية متخصصة تعمل على تطوير حلول علمية وتطبيقية في مختلف المجالات.</p>
        </div>
        <div class="row g-4" id="research-container" data-ssr="1">
            @forelse($centers ?? [] as $center)
                <div class="col-md-6 col-lg-4">
                    <a href="{{ route('research.show', $center->slug) }}" class="text-decoration-none">
                        <article class="research-card h-100">
                            <div class="research-card__icon">
                                <i class="{{ college_fa_icon($center->icon, 'fa-flask') }}"></i>
                            </div>
                            <h3 class="research-card__title">{{ $center->name }}</h3>
                            <p class="research-card__desc">{{ Str::limit(strip_tags($center->description ?? ''), 120) }}</p>
                            <div class="research-card__stats">
                                <span><i class="fas fa-folder-open"></i>{{ number_format($center->projects_count) }} مشروع</span>
                                <span><i class="fas fa-file-lines"></i>{{ number_format($center->publications_count) }} منشور</span>
                            </div>
                        </article>
                    </a>
                </div>
            @empty
                <div class="col-12 text-center text-muted py-5">
                    <i class="fas fa-flask fa-2x mb-3 d-block opacity-50"></i>
                    <p class="mb-0">لا توجد مراكز بحثية متاحة حالياً.</p>
                </div>
            @endforelse
        </div>
    </div>
</section>
