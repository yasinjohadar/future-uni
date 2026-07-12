<aside class="app-sidebar sticky sidebar-premium" id="sidebar">
    <div class="main-sidebar-header">
        <a href="{{ route('doctor.dashboard') }}" class="header-logo">
            <svg class="desktop-logo" width="120" height="40" viewBox="0 0 120 40" xmlns="http://www.w3.org/2000/svg">
                <text x="60" y="26" font-family="Arial, sans-serif" font-size="15" font-weight="700" fill="#1e293b" text-anchor="middle">بوابة الدكتور</text>
            </svg>
            <svg class="toggle-logo" width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                <text x="20" y="25" font-family="Arial, sans-serif" font-size="12" font-weight="700" fill="#2563eb" text-anchor="middle">DR</text>
            </svg>
            <svg class="desktop-white" width="120" height="40" viewBox="0 0 120 40" xmlns="http://www.w3.org/2000/svg">
                <text x="60" y="26" font-family="Arial, sans-serif" font-size="15" font-weight="700" fill="#f8fafc" text-anchor="middle">بوابة الدكتور</text>
            </svg>
            <svg class="toggle-white" width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                <text x="20" y="25" font-family="Arial, sans-serif" font-size="12" font-weight="700" fill="#f8fafc" text-anchor="middle">DR</text>
            </svg>
        </a>
    </div>

    <div class="main-sidebar" id="sidebar-scroll">
        <nav class="main-menu-container nav nav-pills flex-column sub-open">
            <ul class="main-menu">
                <li class="slide">
                    <a href="{{ route('home') }}" class="side-menu__item" target="_blank" rel="noopener noreferrer">
                        <span class="side-menu__icon side-menu__icon--boxed side-menu__icon--frontend">
                            <i class="ri-global-line"></i>
                        </span>
                        <span class="side-menu__label">واجهة الموقع</span>
                        <i class="ri-external-link-line side-menu__angle"></i>
                    </a>
                </li>

                @php
                    $navItems = [
                        ['route' => 'doctor.dashboard', 'match' => 'doctor.dashboard', 'icon' => 'ri-dashboard-3-line', 'label' => 'لوحة التحكم', 'class' => 'side-menu__icon--dashboard'],
                        ['route' => 'doctor.sections.index', 'match' => 'doctor.sections.*', 'icon' => 'ri-book-2-line', 'label' => 'الشعب الدراسية', 'class' => 'side-menu__icon--users'],
                        ['route' => 'doctor.schedule.index', 'match' => 'doctor.schedule.*', 'icon' => 'ri-calendar-schedule-line', 'label' => 'الجدول', 'class' => 'side-menu__icon--dashboard'],
                        ['route' => 'doctor.profile.show', 'match' => 'doctor.profile.*', 'icon' => 'ri-user-line', 'label' => 'الملف الشخصي', 'class' => 'side-menu__icon--users'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <li class="slide {{ request()->routeIs($item['match']) ? 'active' : '' }}">
                        <a href="{{ route($item['route']) }}" class="side-menu__item {{ request()->routeIs($item['match']) ? 'active' : '' }}">
                            <span class="side-menu__icon side-menu__icon--boxed {{ $item['class'] }}">
                                <i class="{{ $item['icon'] }}"></i>
                            </span>
                            <span class="side-menu__label">{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
    </div>
</aside>
