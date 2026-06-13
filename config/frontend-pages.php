<?php

return array (
  'pages' => 
  array (
    'academic-calendar' => 
    array (
      'route' => 'academic-calendar',
      'path' => '/academic-calendar',
      'nav' => NULL,
      'body' => 'calendar-page',
      'title' => 'التقويم الأكاديمي | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'calendar-highlights',
        2 => 'calendar',
        3 => 'calendar-cta',
      ),
    ),
    'admission' => 
    array (
      'route' => 'admission',
      'path' => '/admission',
      'nav' => 'admission',
      'body' => 'admission-page',
      'title' => 'القبول والتسجيل | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'admission-highlights',
        2 => 'admission-quicklinks',
        3 => 'admission',
        4 => 'admission-steps',
        5 => 'admission-form',
        6 => 'admission-cta',
      ),
    ),
    'book-detail' => 
    array (
      'route' => 'book-detail',
      'path' => '/book-detail',
      'nav' => 'library',
      'body' => 'book-detail-page',
      'layout' => 'detail',
      'inline_scripts' => true,
      'title' => 'تفاصيل الكتاب | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'shell',
      ),
    ),
    'cart' => 
    array (
      'route' => 'cart',
      'path' => '/cart',
      'nav' => NULL,
      'body' => NULL,
      'layout' => 'portal',
      'main_js' => true,
      'title' => 'بوابة الطلاب — جامعة المستقبل - السلة',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'content',
      ),
    ),
    'categories' => 
    array (
      'route' => 'categories',
      'path' => '/categories',
      'nav' => NULL,
      'body' => NULL,
      'layout' => 'portal',
      'main_js' => true,
      'title' => 'بوابة الطلاب — جامعة المستقبل - التصنيفات',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'content',
      ),
    ),
    'checkout' => 
    array (
      'route' => 'checkout',
      'path' => '/checkout',
      'nav' => NULL,
      'body' => NULL,
      'layout' => 'portal',
      'main_js' => true,
      'title' => 'بوابة الطلاب — جامعة المستقبل - الدفع',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'content',
      ),
    ),
    'college-detail' => 
    array (
      'route' => 'college-detail',
      'path' => '/college-detail',
      'nav' => 'colleges',
      'body' => 'college-detail-page',
      'layout' => 'detail',
      'title' => 'تفاصيل الكلية | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'shell',
      ),
    ),
    'contact' => 
    array (
      'route' => 'contact',
      'path' => '/contact',
      'nav' => 'contact',
      'body' => 'contact-page',
      'title' => 'تواصل معنا | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'contact-highlights',
        2 => 'contact',
      ),
    ),
    'course-detail' => 
    array (
      'route' => 'course-detail',
      'path' => '/course-detail',
      'nav' => NULL,
      'body' => NULL,
      'layout' => 'portal',
      'main_js' => true,
      'title' => 'بوابة الطلاب — جامعة المستقبل - تفاصيل الكورس',
      'partials' => 
      array (
        0 => 'content',
      ),
    ),
    'courses' => 
    array (
      'route' => 'courses',
      'path' => '/courses',
      'nav' => NULL,
      'body' => NULL,
      'layout' => 'portal',
      'main_js' => true,
      'title' => 'بوابة الطلاب — جامعة المستقبل - الكورسات',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'filters-sidebar',
        2 => 'content-grid',
      ),
    ),
    'departments' => 
    array (
      'route' => 'departments',
      'path' => '/departments',
      'nav' => NULL,
      'body' => 'departments-page',
      'title' => 'الأقسام الأكاديمية | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'departments-highlights',
        2 => 'departments',
        3 => 'departments-cta',
      ),
    ),
    'event-detail' => 
    array (
      'route' => 'event-detail',
      'path' => '/event-detail',
      'nav' => NULL,
      'body' => 'event-detail-page',
      'layout' => 'detail',
      'title' => 'تفاصيل الفعالية | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'shell',
      ),
    ),
    'events' => 
    array (
      'route' => 'events',
      'path' => '/events',
      'nav' => NULL,
      'body' => 'events-page',
      'title' => 'الفعاليات | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'events-highlights',
        2 => 'events',
        3 => 'events-cta',
      ),
    ),
    'faculty' => 
    array (
      'route' => 'faculty',
      'path' => '/faculty',
      'nav' => NULL,
      'body' => 'faculty-page',
      'title' => 'هيئة التدريس | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'faculty-highlights',
        2 => 'faculty',
        3 => 'faculty-cta',
      ),
    ),
    'faq' => 
    array (
      'route' => 'faq',
      'path' => '/faq',
      'nav' => NULL,
      'body' => 'faq-page',
      'title' => 'الأسئلة الشائعة | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'faq-highlights',
        2 => 'faq',
        3 => 'faq-cta',
      ),
    ),
    'forgot-password' => 
    array (
      'route' => 'forgot-password',
      'path' => '/forgot-password',
      'nav' => NULL,
      'body' => 'auth-page',
      'layout' => 'auth',
      'main_js' => true,
      'title' => 'بوابة الطلاب — جامعة المستقبل - استعادة كلمة المرور',
      'partials' => 
      array (
        0 => 'background',
        1 => 'form',
      ),
    ),
    'lesson-view' => 
    array (
      'route' => 'lesson-view',
      'path' => '/lesson-view',
      'nav' => NULL,
      'body' => NULL,
      'layout' => 'portal',
      'main_js' => true,
      'title' => 'بوابة الطلاب — جامعة المستقبل - مشاهدة الدرس',
      'partials' => 
      array (
        0 => 'content',
      ),
    ),
    'library' => 
    array (
      'route' => 'library',
      'path' => '/library',
      'nav' => 'library',
      'body' => 'library-page',
      'title' => 'المكتبة الجامعية | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'library-highlights',
        2 => 'library-toolbar',
        3 => 'library',
        4 => 'library-cta',
      ),
    ),
    'login' => 
    array (
      'route' => 'login',
      'path' => '/login',
      'nav' => NULL,
      'body' => 'auth-page',
      'layout' => 'auth',
      'main_js' => true,
      'title' => 'بوابة الطلاب — جامعة المستقبل - تسجيل الدخول',
      'partials' => 
      array (
        0 => 'background',
        1 => 'form',
      ),
    ),
    'news' => 
    array (
      'route' => 'news',
      'path' => '/news',
      'nav' => 'news',
      'body' => 'news-page',
      'title' => 'الأخبار والفعاليات | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'news-highlights',
        2 => 'news',
        3 => 'news-events',
      ),
    ),
    'privacy' => 
    array (
      'route' => 'privacy',
      'path' => '/privacy',
      'nav' => NULL,
      'body' => 'privacy-page',
      'title' => 'سياسة الخصوصية | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'legal-highlights',
        2 => 'legal',
        3 => 'legal-cta',
      ),
    ),
    'program-detail' => 
    array (
      'route' => 'program-detail',
      'path' => '/program-detail',
      'nav' => NULL,
      'body' => 'program-detail-page',
      'layout' => 'detail',
      'inline_scripts' => true,
      'title' => 'تفاصيل البرنامج | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'shell',
      ),
    ),
    'programs' => 
    array (
      'route' => 'programs',
      'path' => '/programs',
      'nav' => NULL,
      'body' => 'programs-page',
      'title' => 'البرامج الأكاديمية | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'programs-highlights',
        2 => 'programs',
        3 => 'programs-cta',
      ),
    ),
    'register' => 
    array (
      'route' => 'register',
      'path' => '/register',
      'nav' => NULL,
      'body' => 'auth-page',
      'layout' => 'auth',
      'main_js' => true,
      'title' => 'بوابة الطلاب — جامعة المستقبل - إنشاء حساب جديد',
      'partials' => 
      array (
        0 => 'background',
        1 => 'form',
      ),
    ),
    'research-detail' => 
    array (
      'route' => 'research-detail',
      'path' => '/research-detail',
      'nav' => 'research',
      'body' => 'research-detail-page',
      'layout' => 'detail',
      'title' => 'تفاصيل مركز البحث | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'shell',
      ),
    ),
    'research' => 
    array (
      'route' => 'research',
      'path' => '/research',
      'nav' => 'research',
      'body' => 'research-page',
      'title' => 'البحث العلمي | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'research-highlights',
        2 => 'research',
        3 => 'research-pubs',
        4 => 'research-cta',
      ),
    ),
    'scholarships' => 
    array (
      'route' => 'scholarships',
      'path' => '/scholarships',
      'nav' => NULL,
      'body' => 'scholarships-page',
      'title' => 'المنح الدراسية | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'scholarships-highlights',
        2 => 'scholarships',
        3 => 'scholarships-cta',
      ),
    ),
    'staff-detail' => 
    array (
      'route' => 'staff-detail',
      'path' => '/staff-detail',
      'nav' => NULL,
      'body' => 'staff-detail-page',
      'layout' => 'detail',
      'title' => 'تفاصيل العضو | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'shell',
      ),
    ),
    'staff' => 
    array (
      'route' => 'staff',
      'path' => '/staff',
      'nav' => NULL,
      'body' => 'staff-page',
      'title' => 'الهيئة الإدارية | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'staff-highlights',
        2 => 'staff',
        3 => 'staff-cta',
      ),
    ),
    'student-services' => 
    array (
      'route' => 'student-services',
      'path' => '/student-services',
      'nav' => NULL,
      'body' => 'student-services-page',
      'title' => 'خدمات الطلاب | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'services-highlights',
        2 => 'services',
        3 => 'services-cta',
      ),
    ),
    'terms' => 
    array (
      'route' => 'terms',
      'path' => '/terms',
      'nav' => NULL,
      'body' => 'terms-page',
      'title' => 'الشروط والأحكام | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'legal-highlights',
        2 => 'legal',
        3 => 'legal-cta',
      ),
    ),
    'tuition-fees' => 
    array (
      'route' => 'tuition-fees',
      'path' => '/tuition-fees',
      'nav' => NULL,
      'body' => 'tuition-page',
      'title' => 'الرسوم الدراسية | جامعة المستقبل',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'tuition-highlights',
        2 => 'tuition',
        3 => 'tuition-cta',
      ),
    ),
    'who-we-are' => 
    array (
      'route' => 'who-we-are',
      'path' => '/who-we-are',
      'nav' => NULL,
      'body' => NULL,
      'layout' => 'portal',
      'title' => 'بوابة الطلاب — جامعة المستقبل - من نحن',
      'partials' => 
      array (
        0 => 'hero',
        1 => 'content',
      ),
    ),
  ),
);
