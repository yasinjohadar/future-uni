        <!-- Staff Slider Section -->
        <section class="home-staff-section py-5 section-fade-up">
            <div class="container py-4">
                <div class="section-head section-head--center mb-4 mb-md-5">
                    <span class="section-head__eyebrow">القيادة الأكاديمية</span>
                    <h2 class="section-head__title">الهيئة الإدارية</h2>
                    <p class="section-head__desc">نخبة من القادة الأكاديميين ذوي الخبرة والكفاءة العالية.</p>
                </div>

                <div class="home-staff-toolbar d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">
                    <div class="home-staff-nav home-carousel-nav d-flex gap-2">
                        <button type="button" class="home-carousel-nav__btn staff-prev" aria-label="السابق"><i class="fas fa-chevron-right"></i></button>
                        <button type="button" class="home-carousel-nav__btn staff-next" aria-label="التالي"><i class="fas fa-chevron-left"></i></button>
                    </div>
                    <a href="{{ route('staff') }}" class="btn btn-glass home-staff-all-btn d-none d-md-inline-flex">تعرف على القيادة <i class="fas fa-arrow-left ms-2"></i></a>
                </div>

                <div class="home-staff-slider">
                <div class="swiper staff-swiper">
                    <div class="swiper-wrapper" data-ssr="1">
                        @forelse($staffMembers ?? [] as $member)
                        <div class="swiper-slide">
                            <a href="{{ route('staff.show', $member->slug) }}" class="text-decoration-none">
                            <div class="uni-card uni-card--staff h-100">
                                <div class="staff-image">
                                    <i class="fas {{ $member->icon ?? 'fa-user-tie' }}"></i>
                                </div>
                                <h5 class="fw-bold mb-1">{{ $member->name }}</h5>
                                <p class="staff-position mb-2">{{ $member->position }}</p>
                                <p class="text-secondary small uni-card--staff__bio mb-0">{{ Str::limit($member->bio, 100) }}</p>
                                <span class="uni-card--staff__more">عرض الملف <i class="fas fa-arrow-left"></i></span>
                            </div>
                            </a>
                        </div>
                        @empty
                        @endforelse
                    </div>
                    <div class="swiper-pagination staff-pagination"></div>
                </div>
                </div>

                <div class="text-center mt-4 d-md-none">
                    <a href="{{ route('staff') }}" class="btn btn-accent px-5 py-2">تعرف على القيادة <i class="fas fa-arrow-left ms-2"></i></a>
                </div>
            </div>
        </section>
