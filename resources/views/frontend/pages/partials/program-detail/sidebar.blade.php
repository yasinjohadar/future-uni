<aside class="college-detail-sidebar">
    <div class="college-detail-panel section-fade-up">
        <h3 class="college-detail-panel__title"><i class="fas fa-graduation-cap ms-2"></i>البرنامج</h3>
        <div class="college-detail-dean">
            <div class="college-detail-dean__avatar"><i class="fas fa-book-open"></i></div>
            <h5 class="college-detail-dean__name">{{ $program->name }}</h5>
            <p class="college-detail-dean__role">
                <span class="program-level-badge level-{{ $program->level->value }}">{{ $program->level_label }}</span>
            </p>
        </div>
    </div>

    <div class="college-detail-panel section-fade-up">
        <h3 class="college-detail-panel__title"><i class="fas fa-circle-info ms-2"></i>معلومات البرنامج</h3>
        @if($program->duration)
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-clock ms-1 text-accent"></i> المدة</span>
            <span class="college-detail-info-row__value">{{ $program->duration }}</span>
        </div>
        @endif
        @if($program->credits)
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-book ms-1 text-accent"></i> الساعات</span>
            <span class="college-detail-info-row__value en-text">{{ $program->credits }} ساعة</span>
        </div>
        @endif
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-layer-group ms-1 text-accent"></i> المستوى</span>
            <span class="college-detail-info-row__value">{{ $program->level_label }}</span>
        </div>
        @if($program->college)
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-building-columns ms-1 text-accent"></i> الكلية</span>
            <span class="college-detail-info-row__value">{{ $program->college->name }}</span>
        </div>
        @endif
        @if($program->department)
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-sitemap ms-1 text-accent"></i> القسم</span>
            <span class="college-detail-info-row__value">{{ $program->department->name }}</span>
        </div>
        @endif
        @if($program->college?->accreditation)
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-certificate ms-1 text-accent"></i> الاعتماد</span>
            <span class="college-detail-info-row__value en-text">{{ $program->college->accreditation }}</span>
        </div>
        @endif
        @if($program->courses->isNotEmpty())
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-list ms-1 text-accent"></i> المقررات</span>
            <span class="college-detail-info-row__value en-text">{{ $program->courses->count() }}</span>
        </div>
        @endif
    </div>

    @if($program->college?->dean)
    <div class="college-detail-panel section-fade-up">
        <h3 class="college-detail-panel__title"><i class="fas fa-user-tie ms-2"></i>عميد الكلية</h3>
        <div class="college-detail-dean">
            <div class="college-detail-dean__avatar" style="width: 64px; height: 64px; font-size: 1.5rem;"><i class="fas fa-user-tie"></i></div>
            <h5 class="college-detail-dean__name" style="font-size: 0.95rem;">{{ $program->college->dean->name }}</h5>
            @if($program->college->dean->slug)
            <a href="{{ route('staff.show', $program->college->dean->slug) }}" class="btn btn-accent btn-sm w-100">الملف التعريفي</a>
            @endif
        </div>
    </div>
    @endif

    <div class="college-detail-panel section-fade-up">
        <h3 class="college-detail-panel__title"><i class="fas fa-link ms-2"></i>روابط سريعة</h3>
        <div class="d-grid gap-2">
            @if($program->requirements)
            <a href="#program-requirements" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-clipboard-list ms-2 text-accent"></i> متطلبات القبول
            </a>
            @endif
            @if($program->courses->isNotEmpty())
            <a href="#program-courses" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-list ms-2 text-accent"></i> المقررات الدراسية
            </a>
            @endif
            @if($program->college)
            <a href="{{ route('colleges.show', $program->college->slug) }}" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-building-columns ms-2 text-accent"></i> صفحة الكلية
            </a>
            @endif
            @if($program->department)
            <a href="{{ route('departments.show', [$program->college->slug, $program->department->slug]) }}" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-layer-group ms-2 text-accent"></i> صفحة القسم
            </a>
            @endif
            <a href="{{ route('programs') }}" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-search ms-2 text-accent"></i> كل البرامج
            </a>
        </div>
    </div>

    <div class="college-detail-panel college-detail-cta-card section-fade-up">
        <h3 class="college-detail-panel__title"><i class="fas fa-paper-plane ms-2"></i>قدّم طلبك</h3>
        <p class="text-secondary small mb-3">ابدأ رحلتك في {{ $program->name }} عبر بوابة القبول الإلكترونية.</p>
        <a href="{{ route('admission') }}" class="btn btn-accent w-100 mb-2">قدّم الآن</a>
        <a href="{{ route('contact') }}" class="btn btn-glass w-100 btn-sm">استفسار</a>
    </div>
</aside>
