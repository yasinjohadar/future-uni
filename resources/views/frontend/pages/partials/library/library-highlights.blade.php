<section class="library-highlights section-fade-up">
    <div class="container">
        <div class="library-highlights__grid">
            <div class="library-highlight">
                <span class="library-highlight__icon"><i class="fas fa-book"></i></span>
                <div>
                    <strong class="library-highlight__value en-text" id="total-books-count">{{ $highlights['books'] ?? 0 }}</strong>
                    <span class="library-highlight__label">كتاب متوفر</span>
                </div>
            </div>
            <div class="library-highlight">
                <span class="library-highlight__icon"><i class="fas fa-tags"></i></span>
                <div>
                    <strong class="library-highlight__value en-text">{{ $highlights['categories'] ?? 0 }}</strong>
                    <span class="library-highlight__label">تصنيف أكاديمي</span>
                </div>
            </div>
            <div class="library-highlight">
                <span class="library-highlight__icon"><i class="fas fa-database"></i></span>
                <div>
                    <strong class="library-highlight__value en-text">{{ $highlights['digital_references'] ?? '850+' }}</strong>
                    <span class="library-highlight__label">مرجع رقمي</span>
                </div>
            </div>
            <div class="library-highlight">
                <span class="library-highlight__icon"><i class="fas fa-chair"></i></span>
                <div>
                    <strong class="library-highlight__value en-text">{{ $highlights['reading_seats'] ?? 320 }}</strong>
                    <span class="library-highlight__label">مقعد مطالعة</span>
                </div>
            </div>
        </div>
    </div>
</section>
