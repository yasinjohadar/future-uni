<section class="faculty-section section-fade-up">
    <div class="container">
        <div class="section-head text-center mb-4">
            <span class="section-head__eyebrow">فريقنا</span>
            <h2 class="section-head__title">تعرّف على أعضاء هيئة التدريس</h2>
            <p class="section-head__desc mx-auto mb-0" style="max-width: 520px;">صفِّ حسب الكلية لاستكشاف الخبرات والتخصصات الأكاديمية.</p>
        </div>
        <div class="row g-4" id="faculty-container" data-ssr="1">
            @foreach($faculty ?? [] as $member)
            <div class="col-md-6 col-lg-4 col-xl-3 faculty-item" data-college="{{ $member->college_id }}">
                <a href="{{ route('staff.show', $member->slug) }}" class="text-decoration-none">
                    <article class="faculty-card h-100">
                        <div class="faculty-card__avatar"><i class="fas {{ $member->icon ?? 'fa-user-tie' }}"></i></div>
                        <h3 class="faculty-card__name">{{ $member->name }}</h3>
                        <p class="faculty-card__title">{{ $member->academic_title }}</p>
                        @if($member->college)
                        <p class="faculty-card__college"><i class="fas fa-building-columns ms-1"></i>{{ $member->college->name }}</p>
                        @endif
                        @if($member->department)
                        <p class="faculty-card__dept">{{ $member->department->name }}</p>
                        @endif
                        @if($member->specialty)
                        <span class="faculty-card__specialty">{{ Str::limit($member->specialty, 60) }}</span>
                        @endif
                    </article>
                </a>
            </div>
            @endforeach
        </div>
    </div>
</section>
