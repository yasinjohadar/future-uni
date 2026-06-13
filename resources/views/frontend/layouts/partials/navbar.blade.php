@php
    $activeNav = trim($__env->yieldContent('active_nav')) ?: null;
    $brand = config('frontend.brand');
@endphp
<nav class="navbar navbar-expand-lg main-nav glass-nav py-1">
    <div class="container">
        <a class="navbar-brand text-white fw-bold fs-4" href="{{ route('home') }}">
            <i class="fas fa-university me-2" style="color: var(--accent-color);"></i>
            <span class="ms-2">{{ $brand['name'] }}</span><span style="color: var(--accent-color);">{{ $brand['accent'] }}</span>
        </a>

        <button class="navbar-toggler btn-glass border-0" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fas fa-bars text-white"></i>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 pe-0">
                @foreach(config('frontend.nav') as $item)
                    <li class="nav-item">
                        <a class="nav-link {{ $activeNav === $item['key'] ? 'active' : '' }} {{ $loop->first ? 'ps-3' : 'px-3' }} {{ $loop->last ? 'ps-3' : '' }}"
                           href="{{ frontend_link($item) }}">{{ $item['label'] }}</a>
                    </li>
                @endforeach
            </ul>

            <div class="d-flex align-items-center gap-3 mt-3 mt-lg-0 me-lg-4">
                <button class="theme-toggle" aria-label="Toggle Dark Mode">
                    <i class="fas fa-sun"></i>
                </button>
                <div class="dropdown portal-dropdown">
                    <button class="btn btn-glass btn-sm dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-graduate me-1"></i> بوابة الطلاب
                    </button>
                    <ul class="dropdown-menu dropdown-menu-end portal-menu">
                        @foreach(config('frontend.portal') as $portalItem)
                            <li>
                                <a class="dropdown-item" href="{{ frontend_link($portalItem) }}">
                                    <i class="{{ $portalItem['icon'] }} me-2"></i>{{ $portalItem['label'] }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
                <a href="#" class="btn btn-accent btn-sm px-4">قدم الآن</a>
            </div>
        </div>
    </div>
</nav>
