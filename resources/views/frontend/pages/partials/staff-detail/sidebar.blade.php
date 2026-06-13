<aside class="staff-detail-sidebar">
    <div class="staff-detail-panel section-fade-up">
        <div class="staff-detail-profile">
            <div class="staff-detail-avatar"><i class="fas {{ $member->icon ?? 'fa-user-tie' }}"></i></div>
            <h5 class="staff-detail-profile__name">{{ $member->name }}</h5>
            <p class="staff-detail-profile__role">{{ $member->position ?? $member->academic_title ?? $member->type->label() }}</p>
            @if($member->college)
            <p class="staff-detail-profile__college"><i class="fas fa-building-columns ms-1"></i> {{ $member->college->name }}</p>
            @endif
            @if($member->department)
            <p class="staff-detail-profile__college"><i class="fas fa-layer-group ms-1"></i> {{ $member->department->name }}</p>
            @endif
            @if($member->specialty)
            <p class="text-secondary small mt-2 mb-0">{{ $member->specialty }}</p>
            @endif
        </div>
    </div>

    @if($member->email)
    <div class="staff-detail-panel staff-detail-contact-card section-fade-up">
        <i class="fas fa-envelope fa-2x mb-3"></i>
        <h5 class="staff-detail-contact-card__title">تواصل مع العضو</h5>
        <p class="staff-detail-contact-card__desc">للاستفسارات الأكاديمية أو طلب موعد</p>
        <a href="mailto:{{ $member->email }}" class="btn btn-accent w-100 mb-2">إرسال بريد</a>
        <a href="{{ route('contact') }}" class="btn btn-glass w-100 btn-sm">نموذج التواصل</a>
    </div>
    @endif

    @if(!empty($member->skills))
    <div class="staff-detail-panel section-fade-up">
        <h3 class="staff-detail-panel__title"><i class="fas fa-chart-bar ms-2"></i>المهارات</h3>
        @foreach($member->skills as $skill)
        <div class="staff-detail-skill">
            <div class="staff-detail-skill__head">
                <span>{{ $skill['name'] ?? '' }}</span>
                <span>{{ $skill['level'] ?? 0 }}%</span>
            </div>
            <div class="staff-detail-skill__bar">
                <div class="staff-detail-skill__fill" style="width: {{ $skill['level'] ?? 0 }}%;"></div>
            </div>
        </div>
        @endforeach
    </div>
    @endif

    <div class="staff-detail-panel section-fade-up">
        <h3 class="staff-detail-panel__title"><i class="fas fa-address-card ms-2"></i>معلومات التواصل</h3>
        @if($member->email)
        <div class="staff-detail-info-row">
            <span class="staff-detail-info-row__label">البريد</span>
            <span class="staff-detail-info-row__value en-text">{{ $member->email }}</span>
        </div>
        @endif
        @if($member->phone)
        <div class="staff-detail-info-row">
            <span class="staff-detail-info-row__label">الهاتف</span>
            <span class="staff-detail-info-row__value en-text">{{ $member->phone }}</span>
        </div>
        @endif
        @if($member->office)
        <div class="staff-detail-info-row">
            <span class="staff-detail-info-row__label">المكتب</span>
            <span class="staff-detail-info-row__value">{{ $member->office }}</span>
        </div>
        @endif
        <div class="staff-detail-info-row">
            <span class="staff-detail-info-row__label">النوع</span>
            <span class="staff-detail-info-row__value">{{ $member->type->label() }}</span>
        </div>
        @if($member->academic_title)
        <div class="staff-detail-info-row">
            <span class="staff-detail-info-row__label">اللقب</span>
            <span class="staff-detail-info-row__value">{{ $member->academic_title }}</span>
        </div>
        @endif
    </div>

    <div class="staff-detail-panel section-fade-up">
        <h3 class="staff-detail-panel__title"><i class="fas fa-link ms-2"></i>روابط سريعة</h3>
        <div class="d-grid gap-2">
            @if($member->college)
            <a href="{{ route('colleges.show', $member->college->slug) }}" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-building-columns ms-2 text-accent"></i> صفحة الكلية
            </a>
            @endif
            @if($member->department && $member->college)
            <a href="{{ route('departments.show', [$member->college->slug, $member->department->slug]) }}" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-layer-group ms-2 text-accent"></i> صفحة القسم
            </a>
            @endif
            <a href="{{ route($member->type === \App\Enums\StaffType::Faculty ? 'faculty' : 'staff') }}" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-users ms-2 text-accent"></i> {{ $member->type === \App\Enums\StaffType::Faculty ? 'هيئة التدريس' : 'الهيئة الإدارية' }}
            </a>
            <a href="{{ route('admission') }}" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-graduation-cap ms-2 text-accent"></i> القبول والتسجيل
            </a>
        </div>
    </div>

    <div class="staff-detail-panel section-fade-up text-center">
        <h3 class="staff-detail-panel__title justify-content-center"><i class="fas fa-share-nodes ms-2"></i>تابع على</h3>
        <div class="staff-detail-social">
            <a href="#" class="btn btn-glass" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            <a href="#" class="btn btn-glass" aria-label="Twitter"><i class="fab fa-twitter"></i></a>
            <a href="#" class="btn btn-glass" aria-label="Google Scholar"><i class="fab fa-google"></i></a>
            <a href="{{ route('contact') }}" class="btn btn-glass" aria-label="Website"><i class="fas fa-globe"></i></a>
        </div>
    </div>
</aside>
