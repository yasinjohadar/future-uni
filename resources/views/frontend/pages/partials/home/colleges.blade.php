        <!-- Colleges Section -->
        <section class="home-colleges-section py-5 section-fade-up">
            <div class="container py-4">
                <div class="section-head d-flex justify-content-between align-items-end flex-wrap gap-3 mb-4 mb-md-5">
                    <div>
                        <span class="section-head__eyebrow">كلياتنا</span>
                        <h2 class="section-head__title">اكتشف كليات الجامعة</h2>
                    </div>
                    <a href="{{ route('colleges') }}" class="btn btn-glass home-colleges-all-btn d-none d-md-inline-flex">عرض الكل <i class="fas fa-arrow-left ms-2"></i></a>
                </div>
                <div class="row g-3 g-md-4" id="colleges-container" data-ssr="1">
                    @forelse($colleges ?? [] as $college)
                    <div class="col-6 col-md-4 col-lg-2">
                        <a href="{{ route('colleges.show', $college->slug) }}" class="text-decoration-none">
                            <div class="uni-card uni-card--college h-100">
                                <div class="uni-card--college__head">
                                    <div class="college-icon"><i class="fas {{ $college->icon ?? 'fa-building-columns' }}"></i></div>
                                </div>
                                <div class="uni-card--college__body">
                                    <h6>{{ $college->name }}</h6>
                                    <span class="uni-card--college__link">استكشف <i class="fas fa-arrow-left"></i></span>
                                </div>
                            </div>
                        </a>
                    </div>
                    @empty
                    @endforelse
                </div>
                <div class="text-center mt-4 d-md-none">
                    <a href="{{ route('colleges') }}" class="btn btn-glass home-colleges-all-btn">عرض الكل <i class="fas fa-arrow-left ms-2"></i></a>
                </div>
            </div>
        </section>
