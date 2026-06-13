<?php

return [

    'brand' => [
        'name' => 'جامعة',
        'accent' => 'المستقبل',
        'tagline' => 'جامعة رائدة تسعى لتقديم تعليم عالي الجودة وبحث علمي متميز، لإعداد كوادر مؤهلة تقود مسيرة التنمية في المملكة.',
    ],

    'nav' => [
        ['key' => 'home', 'label' => 'الرئيسية', 'route' => 'home'],
        ['key' => 'about', 'label' => 'عن الجامعة', 'route' => 'about'],
        ['key' => 'colleges', 'label' => 'الكليات', 'route' => 'colleges'],
        ['key' => 'admission', 'label' => 'القبول', 'route' => 'admission'],
        ['key' => 'research', 'label' => 'البحث العلمي', 'route' => 'research'],
        ['key' => 'library', 'label' => 'المكتبة', 'route' => 'library'],
        ['key' => 'news', 'label' => 'الأخبار', 'route' => 'blog'],
        ['key' => 'contact', 'label' => 'تواصل', 'route' => 'contact'],
    ],

    'portal' => [
        ['label' => 'المقررات', 'route' => 'courses', 'icon' => 'fas fa-book-open'],
        ['label' => 'تسجيل الدخول', 'route' => 'login', 'icon' => 'fas fa-sign-in-alt'],
        ['label' => 'التسجيل', 'route' => 'register', 'icon' => 'fas fa-user-plus'],
    ],

    'footer_quick_links' => [
        ['label' => 'الرئيسية', 'route' => 'home'],
        ['label' => 'عن الجامعة', 'route' => 'about'],
        ['label' => 'الكليات', 'route' => 'colleges'],
        ['label' => 'القبول', 'route' => 'admission'],
        ['label' => 'سياسة الخصوصية', 'route' => 'privacy'],
        ['label' => 'الشروط والأحكام', 'route' => 'terms'],
    ],

    'footer_services' => [
        ['label' => 'المنح الدراسية', 'route' => 'scholarships'],
        ['label' => 'الرسوم الدراسية', 'route' => 'tuition-fees'],
        ['label' => 'خدمات الطلاب', 'route' => 'student-services'],
        ['label' => 'التقويم الأكاديمي', 'route' => 'academic-calendar'],
        ['label' => 'الفعاليات', 'route' => 'events'],
        ['label' => 'الأسئلة الشائعة', 'route' => 'faq'],
        ['label' => 'هيئة التدريس', 'route' => 'faculty'],
        ['label' => 'البحث العلمي', 'route' => 'research'],
        ['label' => 'المكتبة', 'route' => 'library'],
        ['label' => 'الأخبار', 'route' => 'blog'],
        ['label' => 'بوابة الطلاب', 'route' => 'courses'],
    ],

    'footer_legal' => [
        ['label' => 'سياسة الخصوصية', 'route' => 'privacy'],
        ['label' => 'الشروط والأحكام', 'route' => 'terms'],
        ['label' => 'تواصل معنا', 'route' => 'contact'],
    ],

];
