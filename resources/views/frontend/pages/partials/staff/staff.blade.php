<section class="staff-section staff-section--leadership section-fade-up">
    <div class="container">
        <div class="section-head text-center mb-4">
            <span class="section-head__eyebrow">القيادة</span>
            <h2 class="section-head__title">الإدارة العليا</h2>
        </div>
        <div class="row g-4 justify-content-center" id="staff-leadership-container" data-ssr="1">
            @foreach($leadership ?? [] as $member)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('staff.show', $member->slug) }}" class="text-decoration-none">
                    <div class="uni-card uni-card--staff h-100">
                        <div class="staff-image"><i class="fas {{ $member->icon ?? 'fa-user-tie' }}"></i></div>
                        <h5 class="fw-bold mb-1">{{ $member->name }}</h5>
                        <p class="staff-position mb-2">{{ $member->position }}</p>
                        <p class="text-secondary small mb-0">{{ Str::limit(strip_tags($member->bio ?? ''), 120) }}</p>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>

<section class="staff-section staff-section--deans section-fade-up">
    <div class="container">
        <div class="section-head text-center mb-4">
            <span class="section-head__eyebrow">العمداء</span>
            <h2 class="section-head__title">عمداء الكليات</h2>
        </div>
        <div class="row g-4" id="staff-deans-container" data-ssr="1">
            @foreach($deans ?? [] as $member)
            <div class="col-md-6 col-lg-4">
                <a href="{{ route('staff.show', $member->slug) }}" class="text-decoration-none">
                    <div class="uni-card uni-card--staff h-100">
                        <div class="staff-image"><i class="fas {{ $member->icon ?? 'fa-user-tie' }}"></i></div>
                        <h5 class="fw-bold mb-1">{{ $member->name }}</h5>
                        <p class="staff-position mb-2">{{ $member->position }}</p>
                        @if($member->college)<p class="text-secondary small mb-0">{{ $member->college->name }}</p>@endif
                    </div>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
