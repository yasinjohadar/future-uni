@php
    $brand = config('frontend.brand');
@endphp
<footer class="site-footer">
    <div class="site-footer__top">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-4 col-md-6">
                    <a href="{{ route('home') }}" class="site-footer__brand">
                        <span class="site-footer__brand-icon"><i class="fas fa-university"></i></span>
                        <span class="site-footer__brand-name">{{ $brand['name'] }}<span>{{ $brand['accent'] }}</span></span>
                    </a>
                    <p class="site-footer__desc">{{ $brand['tagline'] }}</p>
                    <div class="site-footer__social">
                        @if(!empty($siteSettings['facebook_url']))
                            <a href="{{ $siteSettings['facebook_url'] }}" target="_blank" rel="noopener noreferrer" aria-label="Facebook"><i class="fab fa-facebook-f"></i></a>
                        @endif
                        @if(!empty($siteSettings['instagram_url']))
                            <a href="{{ $siteSettings['instagram_url'] }}" target="_blank" rel="noopener noreferrer" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        @endif
                        @if(!empty($siteSettings['linkedin_url']))
                            <a href="{{ $siteSettings['linkedin_url'] }}" target="_blank" rel="noopener noreferrer" aria-label="LinkedIn"><i class="fab fa-linkedin-in"></i></a>
                        @endif
                        @if(!empty($siteSettings['youtube_url']))
                            <a href="{{ $siteSettings['youtube_url'] }}" target="_blank" rel="noopener noreferrer" aria-label="YouTube"><i class="fab fa-youtube"></i></a>
                        @endif
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h6 class="site-footer__heading">روابط سريعة</h6>
                    <ul class="site-footer__links">
                        @foreach(config('frontend.footer_quick_links') as $link)
                            <li><a href="{{ frontend_link($link) }}">{{ $link['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="site-footer__heading">خدمات</h6>
                    <ul class="site-footer__links">
                        @foreach(config('frontend.footer_services') as $link)
                            <li><a href="{{ frontend_link($link) }}">{{ $link['label'] }}</a></li>
                        @endforeach
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h6 class="site-footer__heading">تواصل معنا</h6>
                    <ul class="site-footer__contact">
                        @if(!empty($siteSettings['site_address']))
                            <li><i class="fas fa-map-marker-alt"></i><span>{{ $siteSettings['site_address'] }}</span></li>
                        @endif
                        @if(!empty($siteSettings['site_phone']))
                            <li><i class="fas fa-phone"></i><span class="en-text" dir="ltr">{{ $siteSettings['site_phone'] }}</span></li>
                        @endif
                        @if(!empty($siteSettings['site_email']))
                            <li><i class="fas fa-envelope"></i><span>{{ $siteSettings['site_email'] }}</span></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="site-footer__bottom">
        <div class="container">
            <div class="site-footer__bottom-inner">
                <p class="site-footer__copy">&copy; {{ date('Y') }} {{ $brand['name'] }}{{ $brand['accent'] }}. جميع الحقوق محفوظة.</p>
                <div class="site-footer__legal">
                    @foreach(config('frontend.footer_legal') as $link)
                        @if(!$loop->first)
                            <span class="site-footer__dot" aria-hidden="true">·</span>
                        @endif
                        <a href="{{ frontend_link($link) }}">{{ $link['label'] }}</a>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</footer>
