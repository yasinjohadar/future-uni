<section class="college-detail-highlights section-fade-up">
    <div class="container">
        <div class="college-detail-highlights__grid">
            @if($college->established)
            <div class="college-detail-highlight">
                <span class="college-detail-highlight__icon"><i class="fas fa-calendar"></i></span>
                <div>
                    <strong class="college-detail-highlight__value en-text">{{ $college->established }}</strong>
                    <span class="college-detail-highlight__label">سنة التأسيس</span>
                </div>
            </div>
            @endif
            @if($college->students_count)
            <div class="college-detail-highlight">
                <span class="college-detail-highlight__icon"><i class="fas fa-users"></i></span>
                <div>
                    <strong class="college-detail-highlight__value en-text">{{ $college->students_count }}</strong>
                    <span class="college-detail-highlight__label">طالب وطالبة</span>
                </div>
            </div>
            @endif
            <div class="college-detail-highlight">
                <span class="college-detail-highlight__icon"><i class="fas fa-layer-group"></i></span>
                <div>
                    <strong class="college-detail-highlight__value en-text">{{ $college->departments_count }}</strong>
                    <span class="college-detail-highlight__label">قسم أكاديمي</span>
                </div>
            </div>
            @if($college->accreditation)
            <div class="college-detail-highlight">
                <span class="college-detail-highlight__icon"><i class="fas fa-certificate"></i></span>
                <div>
                    <strong class="college-detail-highlight__value en-text">{{ $college->accreditation }}</strong>
                    <span class="college-detail-highlight__label">اعتماد أكاديمي</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
