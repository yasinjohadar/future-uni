        <section class="hero-carousel" aria-label="عرض الجامعة">
            <div class="hero-visual">
                <div class="hero-progress" aria-hidden="true">
                    <div class="hero-progress-fill"></div>
                </div>

                <div class="swiper hero-swiper">
                    <div class="swiper-wrapper">
                        @forelse($heroSlides ?? [] as $slide)
                        <div class="swiper-slide">
                            <div class="hero-slide-bg" @if($slide->background_image) style="background-image: url('{{ $slide->background_image }}');" @endif></div>
                            <div class="hero-slide-overlay"></div>
                            <div class="hero-slide-pattern"></div>
                            <div class="hero-slide-inner">
                                <div class="container">
                                    <div class="row justify-content-start">
                                        <div class="col-lg-9 col-xl-8">
                                            <div class="hero-luxury-panel">
                                                <div class="hero-cinematic-content" aria-live="polite">
                                                    @if($slide->badge)
                                                    <span class="hero-slide-badge"><i class="fas fa-award me-2"></i>{{ $slide->badge }}</span>
                                                    @endif
                                                    <h1 class="hero-slide-title">{!! nl2br(e($slide->title)) !!}@if($slide->title_accent)<br><span class="text-accent">{{ $slide->title_accent }}</span>@endif</h1>
                                                    @if($slide->description)<p class="hero-slide-desc">{{ $slide->description }}</p>@endif
                                                    <div class="hero-ctas">
                                                        @if($slide->primary_btn_label && $slide->primary_btn_url)
                                                        <a href="{{ $slide->primary_btn_url }}" class="btn btn-hero-primary">{{ $slide->primary_btn_label }} <i class="fas fa-arrow-left ms-2"></i></a>
                                                        @endif
                                                        @if($slide->secondary_btn_label && $slide->secondary_btn_url)
                                                        <a href="{{ $slide->secondary_btn_url }}" class="btn btn-hero-secondary">{{ $slide->secondary_btn_label }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @empty
                        @endforelse
                    </div>
                </div>

                <div class="hero-bottom-bar">
                    <div class="container">
                        <div class="hero-bottom-bar__inner">
                            <div class="hero-slide-counter" aria-live="polite">
                                <span class="hero-slide-counter__current en-text">01</span>
                                <span class="hero-slide-counter__line" aria-hidden="true"></span>
                                <span class="hero-slide-counter__total en-text">{{ str_pad((string) max(1, ($heroSlides ?? collect())->count()), 2, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            <div class="hero-pagination"></div>
                            <div class="hero-controls-nav">
                                <button type="button" class="hero-nav-btn hero-prev" aria-label="الشريحة السابقة"><i class="fas fa-chevron-right"></i></button>
                                <button type="button" class="hero-nav-btn hero-next" aria-label="الشريحة التالية"><i class="fas fa-chevron-left"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hero-carousel__edge" aria-hidden="true"></div>
        </section>
