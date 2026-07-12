<aside class="app-sidebar sticky sidebar-premium" id="sidebar">
    <div class="main-sidebar-header">
        <a href="{{ route('student.dashboard') }}" class="header-logo">
            <svg class="desktop-logo" width="120" height="40" viewBox="0 0 120 40" xmlns="http://www.w3.org/2000/svg">
                <text x="60" y="26" font-family="Arial, sans-serif" font-size="15" font-weight="700" fill="#1e293b" text-anchor="middle">بوابة الطالب</text>
            </svg>
            <svg class="toggle-logo" width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                <text x="20" y="25" font-family="Arial, sans-serif" font-size="12" font-weight="700" fill="#2563eb" text-anchor="middle">ST</text>
            </svg>
            <svg class="desktop-white" width="120" height="40" viewBox="0 0 120 40" xmlns="http://www.w3.org/2000/svg">
                <text x="60" y="26" font-family="Arial, sans-serif" font-size="15" font-weight="700" fill="#f8fafc" text-anchor="middle">بوابة الطالب</text>
            </svg>
            <svg class="toggle-white" width="40" height="40" viewBox="0 0 40 40" xmlns="http://www.w3.org/2000/svg">
                <text x="20" y="25" font-family="Arial, sans-serif" font-size="12" font-weight="700" fill="#f8fafc" text-anchor="middle">ST</text>
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
                        ['route' => 'student.dashboard', 'icon' => 'ri-dashboard-3-line', 'label' => 'لوحة التحكم', 'class' => 'side-menu__icon--dashboard'],
                        ['route' => 'student.courses.index', 'icon' => 'ri-book-open-line', 'label' => 'مقرراتي', 'class' => 'side-menu__icon--users'],
                        ['route' => 'student.schedule.index', 'icon' => 'ri-calendar-schedule-line', 'label' => 'الجدول', 'class' => 'side-menu__icon--dashboard'],
                        ['route' => 'student.grades.index', 'icon' => 'ri-medal-line', 'label' => 'الدرجات', 'class' => 'side-menu__icon--users'],
                        ['route' => 'student.study-plan.index', 'icon' => 'ri-road-map-line', 'label' => 'الخطة الدراسية', 'class' => 'side-menu__icon--dashboard'],
                        ['route' => 'student.registration.index', 'icon' => 'ri-edit-box-line', 'label' => 'التسجيل', 'class' => 'side-menu__icon--users'],
                        ['route' => 'student.announcements.index', 'icon' => 'ri-megaphone-line', 'label' => 'الإعلانات', 'class' => 'side-menu__icon--dashboard'],
                        ['route' => 'student.finance.index', 'icon' => 'ri-wallet-3-line', 'label' => 'المالية', 'class' => 'side-menu__icon--users'],
                        ['route' => 'student.library.index', 'icon' => 'ri-book-read-line', 'label' => 'المكتبة', 'class' => 'side-menu__icon--dashboard'],
                        ['route' => 'student.profile.show', 'icon' => 'ri-user-line', 'label' => 'الملف الشخصي', 'class' => 'side-menu__icon--users'],
                    ];
                @endphp

                @foreach($navItems as $item)
                    <li class="slide {{ request()->routeIs($item['route']) ? 'active' : '' }}">
                        <a href="{{ route($item['route']) }}" class="side-menu__item {{ request()->routeIs($item['route']) ? 'active' : '' }}">
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
