@php
    $shortDeptName = str_replace('قسم ', '', $department->name);
    $bachelorCount = $department->programs->filter(fn ($p) => $p->level?->value === 'bachelor')->count();
    $graduateCount = $department->programs->count() - $bachelorCount;
@endphp

<aside class="college-detail-sidebar">
    <div class="college-detail-panel section-fade-up">
        <h3 class="college-detail-panel__title"><i class="fas {{ $department->icon ?? 'fa-layer-group' }} ms-2"></i>القسم</h3>
        <div class="college-detail-dean">
            <div class="college-detail-dean__avatar"><i class="fas {{ $department->icon ?? 'fa-layer-group' }}"></i></div>
            <h5 class="college-detail-dean__name">{{ $department->name }}</h5>
            <p class="college-detail-dean__role">{{ $college->name }}</p>
            <a href="{{ route('colleges.show', $college->slug) }}" class="btn btn-glass btn-sm w-100">صفحة الكلية</a>
        </div>
    </div>

    <div class="college-detail-panel section-fade-up">
        <h3 class="college-detail-panel__title"><i class="fas fa-circle-info ms-2"></i>معلومات القسم</h3>
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-building-columns ms-1 text-accent"></i> الكلية</span>
            <span class="college-detail-info-row__value">{{ $college->name }}</span>
        </div>
        @if($college->building)
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-building ms-1 text-accent"></i> المبنى</span>
            <span class="college-detail-info-row__value">{{ $college->building }}</span>
        </div>
        @endif
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-book-open ms-1 text-accent"></i> البرامج</span>
            <span class="college-detail-info-row__value en-text">{{ $department->programs_count }}</span>
        </div>
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-chalkboard-user ms-1 text-accent"></i> هيئة التدريس</span>
            <span class="college-detail-info-row__value en-text">{{ $department->faculty_count }}</span>
        </div>
        @if($bachelorCount > 0)
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-graduation-cap ms-1 text-accent"></i> بكالوريوس</span>
            <span class="college-detail-info-row__value en-text">{{ $bachelorCount }}</span>
        </div>
        @endif
        @if($graduateCount > 0)
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-user-graduate ms-1 text-accent"></i> دراسات عليا</span>
            <span class="college-detail-info-row__value en-text">{{ $graduateCount }}</span>
        </div>
        @endif
        @if($college->accreditation)
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-certificate ms-1 text-accent"></i> الاعتماد</span>
            <span class="college-detail-info-row__value en-text">{{ $college->accreditation }}</span>
        </div>
        @endif
    </div>

    @if($college->dean)
    <div class="college-detail-panel section-fade-up">
        <h3 class="college-detail-panel__title"><i class="fas fa-user-tie ms-2"></i>عميد الكلية</h3>
        <div class="college-detail-dean">
            <div class="college-detail-dean__avatar" style="width: 64px; height: 64px; font-size: 1.5rem;"><i class="fas fa-user-tie"></i></div>
            <h5 class="college-detail-dean__name" style="font-size: 0.95rem;">{{ $college->dean->name }}</h5>
            @if($college->dean->slug)
            <a href="{{ route('staff.show', $college->dean->slug) }}" class="btn btn-accent btn-sm w-100">الملف التعريفي</a>
            @endif
        </div>
    </div>
    @endif

    <div class="college-detail-panel section-fade-up">
        <h3 class="college-detail-panel__title"><i class="fas fa-link ms-2"></i>روابط سريعة</h3>
        <div class="d-grid gap-2">
            @if($department->programs->isNotEmpty())
            <a href="#dept-programs" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-book-open ms-2 text-accent"></i> برامج القسم
            </a>
            @endif
            <a href="{{ route('colleges.show', $college->slug) }}" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-building-columns ms-2 text-accent"></i> العودة للكلية
            </a>
            @if($siblingDepartments->isNotEmpty())
            <a href="{{ route('colleges.show', $college->slug) }}#college-departments" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-layer-group ms-2 text-accent"></i> أقسام أخرى ({{ $siblingDepartments->count() }})
            </a>
            @endif
            <a href="{{ route('faculty') }}" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-users ms-2 text-accent"></i> هيئة التدريس
            </a>
        </div>
    </div>

    <div class="college-detail-panel college-detail-cta-card section-fade-up">
        <h3 class="college-detail-panel__title"><i class="fas fa-graduation-cap ms-2"></i>انضم للقسم</h3>
        <p class="text-secondary small mb-3">قدّم طلب قبول في {{ $shortDeptName }} عبر {{ $college->name }}.</p>
        <a href="{{ route('admission') }}" class="btn btn-accent w-100 mb-2">قدّم الآن</a>
        <a href="{{ route('contact') }}" class="btn btn-glass w-100 btn-sm">استفسار</a>
    </div>
</aside>
