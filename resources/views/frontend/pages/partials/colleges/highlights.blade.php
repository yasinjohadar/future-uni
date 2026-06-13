<section class="colleges-highlights section-fade-up">
    <div class="container">
        <div class="colleges-highlights__grid">
            <div class="colleges-highlight">
                <span class="colleges-highlight__icon"><i class="fas fa-building-columns"></i></span>
                <div>
                    <strong class="colleges-highlight__value en-text">{{ $highlights['colleges'] ?? 0 }}</strong>
                    <span class="colleges-highlight__label">كلية أكاديمية</span>
                </div>
            </div>
            <div class="colleges-highlight">
                <span class="colleges-highlight__icon"><i class="fas fa-book-open"></i></span>
                <div>
                    <strong class="colleges-highlight__value en-text">{{ ($highlights['programs'] ?? 0) }}+</strong>
                    <span class="colleges-highlight__label">برنامج أكاديمي</span>
                </div>
            </div>
            <div class="colleges-highlight">
                <span class="colleges-highlight__icon"><i class="fas fa-layer-group"></i></span>
                <div>
                    <strong class="colleges-highlight__value en-text">{{ ($highlights['departments'] ?? 0) }}+</strong>
                    <span class="colleges-highlight__label">قسم علمي</span>
                </div>
            </div>
            <div class="colleges-highlight">
                <span class="colleges-highlight__icon"><i class="fas fa-graduation-cap"></i></span>
                <div>
                    <strong class="colleges-highlight__value">3</strong>
                    <span class="colleges-highlight__label">مستويات دراسية</span>
                </div>
            </div>
        </div>
    </div>
</section>
