@php
    $shortName = str_replace('كلية ', '', $college->name);
    $facultyTotal = $college->departments->sum('faculty_count');
@endphp

<aside class="college-detail-sidebar">
    @if($college->dean)
    <div class="college-detail-panel section-fade-up">
        <h3 class="college-detail-panel__title"><i class="fas fa-user-tie ms-2"></i>عميد الكلية</h3>
        <div class="college-detail-dean">
            <div class="college-detail-dean__avatar"><i class="fas fa-user-tie"></i></div>
            <h5 class="college-detail-dean__name">{{ $college->dean->name }}</h5>
            <p class="college-detail-dean__role">عميد {{ $shortName }}</p>
            @if($college->dean->slug)
            <a href="{{ route('staff.show', $college->dean->slug) }}" class="btn btn-accent btn-sm w-100">الملف التعريفي</a>
            @endif
        </div>
    </div>
    @endif

    <div class="college-detail-panel section-fade-up">
        <h3 class="college-detail-panel__title"><i class="fas fa-circle-info ms-2"></i>معلومات الكلية</h3>
        @if($college->established)
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-calendar ms-1 text-accent"></i> سنة التأسيس</span>
            <span class="college-detail-info-row__value en-text">{{ $college->established }}</span>
        </div>
        @endif
        @if($college->students_count)
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-users ms-1 text-accent"></i> الطلاب</span>
            <span class="college-detail-info-row__value en-text">{{ $college->students_count }}</span>
        </div>
        @endif
        @if($college->building)
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-building ms-1 text-accent"></i> المبنى</span>
            <span class="college-detail-info-row__value">{{ $college->building }}</span>
        </div>
        @endif
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-layer-group ms-1 text-accent"></i> الأقسام</span>
            <span class="college-detail-info-row__value en-text">{{ $college->departments_count }}</span>
        </div>
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-book-open ms-1 text-accent"></i> البرامج</span>
            <span class="college-detail-info-row__value en-text">{{ $college->programs_count }}+</span>
        </div>
        @if($facultyTotal > 0)
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-chalkboard-user ms-1 text-accent"></i> هيئة التدريس</span>
            <span class="college-detail-info-row__value en-text">{{ $facultyTotal }}+</span>
        </div>
        @endif
        @if($college->accreditation)
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-certificate ms-1 text-accent"></i> الاعتماد</span>
            <span class="college-detail-info-row__value en-text">{{ $college->accreditation }}</span>
        </div>
        @endif
        @if($college->category && $college->category !== 'all')
        @php
            $categoryLabels = [
                'engineering' => 'الهندسة والتقنية',
                'medical' => 'العلوم الطبية',
                'business' => 'الإدارة والإنسانية',
                'science' => 'العلوم الأساسية',
            ];
        @endphp
        <div class="college-detail-info-row">
            <span class="college-detail-info-row__label"><i class="fas fa-tags ms-1 text-accent"></i> التصنيف</span>
            <span class="college-detail-info-row__value">{{ $categoryLabels[$college->category] ?? $college->category }}</span>
        </div>
        @endif
    </div>

    @if($college->departments->isNotEmpty() || $college->programs->isNotEmpty())
    <div class="college-detail-panel section-fade-up">
        <h3 class="college-detail-panel__title"><i class="fas fa-link ms-2"></i>روابط سريعة</h3>
        <div class="d-grid gap-2">
            @if($college->departments->isNotEmpty())
            <a href="#college-departments" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-layer-group ms-2 text-accent"></i> الأقسام الأكاديمية
            </a>
            @endif
            @if($college->programs->isNotEmpty())
            <a href="#college-programs" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-book-open ms-2 text-accent"></i> البرامج الدراسية
            </a>
            @endif
            <a href="{{ route('programs') }}?college={{ $college->slug }}" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-search ms-2 text-accent"></i> استكشف كل البرامج
            </a>
            <a href="{{ route('faculty') }}" class="btn btn-glass btn-sm text-start">
                <i class="fas fa-chalkboard-user ms-2 text-accent"></i> هيئة التدريس
            </a>
        </div>
    </div>
    @endif

    <div class="college-detail-panel college-detail-cta-card section-fade-up">
        <h3 class="college-detail-panel__title"><i class="fas fa-graduation-cap ms-2"></i>انضم إلينا</h3>
        <p class="text-secondary small mb-3">قدّم طلب القبول في {{ $college->name }} أو تواصل مع فريق القبول للاستفسار.</p>
        <a href="{{ route('admission') }}" class="btn btn-accent w-100 mb-2">قدّم الآن</a>
        <a href="{{ route('contact') }}" class="btn btn-glass w-100 btn-sm">تواصل معنا</a>
    </div>
</aside>
