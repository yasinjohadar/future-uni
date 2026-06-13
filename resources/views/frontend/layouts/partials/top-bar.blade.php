<div class="top-bar d-none d-md-block">
    <div class="container d-flex justify-content-between align-items-center">
        <div class="d-flex gap-4 align-items-center">
            @if(!empty($siteSettings['site_email']))
                <span class="top-bar-item"><i class="fas fa-envelope me-2"></i>{{ $siteSettings['site_email'] }}</span>
            @endif
            @if(!empty($siteSettings['site_phone']))
                <span class="top-bar-item"><i class="fas fa-phone me-2"></i>{{ $siteSettings['site_phone'] }}</span>
            @endif
        </div>
        <div class="d-flex gap-2 align-items-center">
            @if(!empty($siteSettings['facebook_url']))
                <a href="{{ $siteSettings['facebook_url'] }}" class="top-bar-social" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
            @endif
            @if(!empty($siteSettings['instagram_url']))
                <a href="{{ $siteSettings['instagram_url'] }}" class="top-bar-social" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
            @endif
            @if(!empty($siteSettings['linkedin_url']))
                <a href="{{ $siteSettings['linkedin_url'] }}" class="top-bar-social" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
            @endif
            @if(!empty($siteSettings['youtube_url']))
                <a href="{{ $siteSettings['youtube_url'] }}" class="top-bar-social" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
            @endif
        </div>
    </div>
</div>
