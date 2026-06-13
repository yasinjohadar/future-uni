<section class="page-hero">
    <div class="container">
        <div class="page-hero-content">
            <div class="page-hero-icon"><i class="{{ $heroIcon }}"></i></div>
            <h1 class="page-hero-title">{{ $heroTitle }}</h1>
            @if(!empty($heroSubtitle))
                <p class="page-hero-subtitle">{{ $heroSubtitle }}</p>
            @endif
            @if(!empty($breadcrumbs))
                <div class="page-hero-breadcrumb">
                    @foreach($breadcrumbs as $crumb)
                        @if(!empty($crumb['route']))
                            <a href="{{ route($crumb['route']) }}">{{ $crumb['label'] }}</a>
                        @elseif(!empty($crumb['url']))
                            <a href="{{ $crumb['url'] }}">{{ $crumb['label'] }}</a>
                        @else
                            <span class="current">{{ $crumb['label'] }}</span>
                        @endif
                        @if(!$loop->last)
                            <span class="sep"><i class="fas fa-chevron-left"></i></span>
                        @endif
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</section>
