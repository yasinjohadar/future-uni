        <!-- Stats Section -->
        <section class="hero-stats-section section-fade-up">
            <div class="container">
                <div class="row g-4">
                    @forelse($homepageStats ?? [] as $stat)
                    <div class="col-6 col-md-3">
                        <div class="uni-card uni-card--stat h-100">
                            <div class="uni-card__icon"><i class="fas {{ $stat->icon ?? 'fa-chart-line' }}"></i></div>
                            <h2 class="fw-bold counter en-text" data-target="{{ preg_replace('/[^0-9]/', '', $stat->value) ?: $stat->value }}">{{ $stat->value }}</h2>
                            <p class="text-secondary m-0">{{ $stat->label }}</p>
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </section>
