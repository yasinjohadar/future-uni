@if(!empty($member->stats))
<section class="staff-detail-highlights section-fade-up">
    <div class="container">
        <div class="staff-detail-highlights__grid">
            @if(isset($member->stats['publications']))
            <div class="staff-detail-highlight">
                <span class="staff-detail-highlight__icon"><i class="fas fa-file-lines"></i></span>
                <div>
                    <strong class="staff-detail-highlight__value en-text">{{ $member->stats['publications'] }}</strong>
                    <span class="staff-detail-highlight__label">منشور علمي</span>
                </div>
            </div>
            @endif
            @if(isset($member->stats['citations']))
            <div class="staff-detail-highlight">
                <span class="staff-detail-highlight__icon"><i class="fas fa-quote-right"></i></span>
                <div>
                    <strong class="staff-detail-highlight__value en-text">{{ number_format($member->stats['citations']) }}</strong>
                    <span class="staff-detail-highlight__label">استشهاد</span>
                </div>
            </div>
            @endif
            @if(isset($member->stats['hIndex']))
            <div class="staff-detail-highlight">
                <span class="staff-detail-highlight__icon"><i class="fas fa-chart-line"></i></span>
                <div>
                    <strong class="staff-detail-highlight__value en-text">{{ $member->stats['hIndex'] }}</strong>
                    <span class="staff-detail-highlight__label">h-index</span>
                </div>
            </div>
            @endif
            @if(isset($member->stats['experience']))
            <div class="staff-detail-highlight">
                <span class="staff-detail-highlight__icon"><i class="fas fa-briefcase"></i></span>
                <div>
                    <strong class="staff-detail-highlight__value en-text">{{ $member->stats['experience'] }}</strong>
                    <span class="staff-detail-highlight__label">سنة خبرة</span>
                </div>
            </div>
            @endif
        </div>
    </div>
</section>
@endif
