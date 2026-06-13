        <!-- Accreditations Section -->
        <section class="py-5 section-fade-up">
            <div class="container py-4">
                <div class="section-head section-head--center mb-5">
                    <span class="section-head__eyebrow">جودة معتمدة</span>
                    <h2 class="section-head__title">الاعتمادات الأكاديمية</h2>
                    <p class="section-head__desc">حاصلة على اعتمادات محلية ودولية تضمن أعلى معايير الجودة الأكاديمية.</p>
                </div>
                <div class="row g-4 justify-content-center">
                    @forelse($accreditations ?? [] as $item)
                    <div class="col-6 col-md-4 col-lg-2">
                        <div class="uni-card uni-card--accreditation h-100">
                            <div class="accreditation-icon-wrapper"><i class="fas {{ $item->icon ?? 'fa-certificate' }}"></i></div>
                            <h6 class="fw-bold small mb-1">{{ $item->name }}</h6>
                            @if($item->description)<p class="text-secondary small m-0" style="font-size:0.7rem;">{{ $item->description }}</p>@endif
                        </div>
                    </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </section>
