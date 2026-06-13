<section class="college-detail-highlights section-fade-up">
    <div class="container">
        <div class="college-detail-highlights__grid">
            <div class="college-detail-highlight">
                <span class="college-detail-highlight__icon"><i class="fas fa-book-open"></i></span>
                <div>
                    <strong class="college-detail-highlight__value en-text">{{ $department->programs_count }}</strong>
                    <span class="college-detail-highlight__label">برنامج دراسي</span>
                </div>
            </div>
            <div class="college-detail-highlight">
                <span class="college-detail-highlight__icon"><i class="fas fa-chalkboard-user"></i></span>
                <div>
                    <strong class="college-detail-highlight__value en-text">{{ $department->faculty_count }}</strong>
                    <span class="college-detail-highlight__label">عضو هيئة تدريس</span>
                </div>
            </div>
            <div class="college-detail-highlight">
                <span class="college-detail-highlight__icon"><i class="fas fa-building-columns"></i></span>
                <div>
                    <strong class="college-detail-highlight__value">{{ Str::limit($college->name, 18) }}</strong>
                    <span class="college-detail-highlight__label">الكلية الأم</span>
                </div>
            </div>
            @if($college->accreditation)
            <div class="college-detail-highlight">
                <span class="college-detail-highlight__icon"><i class="fas fa-certificate"></i></span>
                <div>
                    <strong class="college-detail-highlight__value en-text">{{ $college->accreditation }}</strong>
                    <span class="college-detail-highlight__label">اعتماد الكلية</span>
                </div>
            </div>
            @elseif($college->departments_count)
            <div class="college-detail-highlight">
                <span class="college-detail-highlight__icon"><i class="fas fa-layer-group"></i></span>
                <div>
                    <strong class="college-detail-highlight__value en-text">{{ $college->departments_count }}</strong>
                    <span class="college-detail-highlight__label">قسم في الكلية</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
