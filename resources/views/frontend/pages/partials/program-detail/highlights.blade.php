<section class="college-detail-highlights section-fade-up">
    <div class="container">
        <div class="college-detail-highlights__grid">
            @if($program->duration)
            <div class="college-detail-highlight">
                <span class="college-detail-highlight__icon"><i class="fas fa-clock"></i></span>
                <div>
                    <strong class="college-detail-highlight__value">{{ $program->duration }}</strong>
                    <span class="college-detail-highlight__label">مدة البرنامج</span>
                </div>
            </div>
            @endif
            @if($program->credits)
            <div class="college-detail-highlight">
                <span class="college-detail-highlight__icon"><i class="fas fa-book-open"></i></span>
                <div>
                    <strong class="college-detail-highlight__value en-text">{{ $program->credits }}</strong>
                    <span class="college-detail-highlight__label">ساعة معتمدة</span>
                </div>
            </div>
            @endif
            <div class="college-detail-highlight">
                <span class="college-detail-highlight__icon"><i class="fas fa-graduation-cap"></i></span>
                <div>
                    <strong class="college-detail-highlight__value">{{ $program->level_label }}</strong>
                    <span class="college-detail-highlight__label">المستوى الدراسي</span>
                </div>
            </div>
            @if($program->college)
            <div class="college-detail-highlight">
                <span class="college-detail-highlight__icon"><i class="fas fa-building-columns"></i></span>
                <div>
                    <strong class="college-detail-highlight__value">{{ Str::limit($program->college->name, 18) }}</strong>
                    <span class="college-detail-highlight__label">الكلية</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
