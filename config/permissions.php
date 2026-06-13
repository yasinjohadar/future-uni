<?php

/**
 * سجل صلاحيات لوحة التحكم: التصنيفات، الأسماء التقنية، والتسميات العربية.
 */
return [
    'groups' => [
        'dashboard' => [
            'label' => 'لوحة التحكم',
            'permissions' => [
                'dashboard-view' => 'عرض لوحة التحكم',
            ],
        ],
        'roles' => [
            'label' => 'الأدوار والصلاحيات',
            'permissions' => [
                'role-list' => 'عرض قائمة الأدوار',
                'role-create' => 'إنشاء دور',
                'role-edit' => 'تعديل دور',
                'role-delete' => 'حذف دور',
            ],
        ],
        'users' => [
            'label' => 'المستخدمون',
            'permissions' => [
                'user-list' => 'عرض قائمة المستخدمين',
                'user-create' => 'إنشاء مستخدم',
                'user-edit' => 'تعديل مستخدم',
                'user-delete' => 'حذف مستخدم',
                'user-show' => 'عرض تفاصيل مستخدم',
                'user-toggle-status' => 'تفعيل/تعطيل مستخدم',
                'user-update-password' => 'تغيير كلمة مرور مستخدم',
            ],
        ],
        'blog_posts' => [
            'label' => 'المدونة — المقالات',
            'permissions' => [
                'blog-post-list' => 'عرض المقالات',
                'blog-post-create' => 'إنشاء مقال',
                'blog-post-edit' => 'تعديل مقال',
                'blog-post-delete' => 'حذف مقال',
                'blog-post-toggle-featured' => 'تمييز/إلغاء تمييز مقال',
                'blog-post-toggle-publish' => 'نشر/إلغاء نشر مقال',
            ],
        ],
        'blog_categories' => [
            'label' => 'المدونة — التصنيفات',
            'permissions' => [
                'blog-category-list' => 'عرض التصنيفات',
                'blog-category-create' => 'إنشاء تصنيف',
                'blog-category-edit' => 'تعديل تصنيف',
                'blog-category-delete' => 'حذف تصنيف',
            ],
        ],
        'blog_tags' => [
            'label' => 'المدونة — الوسوم',
            'permissions' => [
                'blog-tag-list' => 'عرض الوسوم',
                'blog-tag-create' => 'إنشاء وسم',
                'blog-tag-edit' => 'تعديل وسم',
                'blog-tag-delete' => 'حذف وسم',
            ],
        ],
        'blog_ai' => [
            'label' => 'المدونة — الذكاء الاصطناعي',
            'permissions' => [
                'blog-ai-create' => 'إنشاء مقال بالذكاء الاصطناعي',
                'blog-ai-generate' => 'توليد محتوى مقال',
            ],
        ],
        'contact_messages' => [
            'label' => 'رسائل التواصل',
            'permissions' => [
                'contact-message-list' => 'عرض الرسائل',
                'contact-message-show' => 'عرض تفاصيل رسالة',
                'contact-message-delete' => 'حذف رسالة',
            ],
        ],
        'consultation_requests' => [
            'label' => 'طلبات الاستشارة',
            'permissions' => [
                'consultation-request-list' => 'عرض الطلبات',
                'consultation-request-show' => 'عرض تفاصيل طلب',
                'consultation-request-delete' => 'حذف طلب',
            ],
        ],
        'newsletter' => [
            'label' => 'النشرة البريدية',
            'permissions' => [
                'newsletter-list' => 'عرض المشتركين',
                'newsletter-export' => 'تصدير المشتركين',
                'newsletter-delete' => 'حذف مشترك',
            ],
        ],
        'settings_site' => [
            'label' => 'إعدادات الموقع',
            'permissions' => [
                'settings-site-view' => 'عرض إعدادات الموقع',
                'settings-site-edit' => 'تعديل إعدادات الموقع',
            ],
        ],
        'settings_email' => [
            'label' => 'إعدادات البريد',
            'permissions' => [
                'settings-email-list' => 'عرض إعدادات البريد',
                'settings-email-create' => 'إضافة إعداد بريد',
                'settings-email-edit' => 'تعديل إعداد بريد',
                'settings-email-delete' => 'حذف إعداد بريد',
                'settings-email-activate' => 'تفعيل إعداد بريد',
                'settings-email-test' => 'اختبار إعداد بريد',
            ],
        ],
        'storage' => [
            'label' => 'التخزين السحابي',
            'permissions' => [
                'storage-list' => 'عرض أماكن التخزين',
                'storage-create' => 'إضافة مكان تخزين',
                'storage-edit' => 'تعديل مكان تخزين',
                'storage-delete' => 'حذف مكان تخزين',
                'storage-test' => 'اختبار اتصال التخزين',
                'storage-analytics' => 'عرض إحصائيات التخزين',
            ],
        ],
        'storage_disk_mappings' => [
            'label' => 'ربط الأقراص',
            'permissions' => [
                'storage-disk-mapping-list' => 'عرض ربط الأقراص',
                'storage-disk-mapping-create' => 'إضافة ربط قرص',
                'storage-disk-mapping-edit' => 'تعديل ربط قرص',
                'storage-disk-mapping-delete' => 'حذف ربط قرص',
            ],
        ],
        'storage_settings' => [
            'label' => 'إعدادات التخزين',
            'permissions' => [
                'storage-settings-view' => 'عرض إعدادات التخزين',
                'storage-settings-edit' => 'تعديل إعدادات التخزين',
            ],
        ],
        'storage_migration' => [
            'label' => 'ترحيل التخزين',
            'permissions' => [
                'storage-migration-view' => 'عرض لوحة الترحيل',
                'storage-migration-run' => 'تشغيل الترحيل للسحابة',
            ],
        ],
        'media' => [
            'label' => 'إدارة الوسائط',
            'permissions' => [
                'media-list' => 'عرض الوسائط',
                'media-show' => 'عرض تفاصيل وسيط',
                'media-delete' => 'حذف وسيط',
                'media-sync' => 'مزامنة وسيط',
                'media-dead-letters' => 'إدارة فشل المزامنة',
                'media-monitoring-view' => 'لوحة مراقبة الوسائط',
            ],
        ],
        'backups' => [
            'label' => 'النسخ الاحتياطي',
            'permissions' => [
                'backup-list' => 'عرض النسخ الاحتياطية',
                'backup-create' => 'إنشاء نسخة احتياطية',
                'backup-delete' => 'حذف نسخة',
                'backup-download' => 'تنزيل نسخة',
                'backup-restore' => 'استعادة نسخة',
                'backup-run' => 'تشغيل نسخة يدوياً',
            ],
        ],
        'backup_schedules' => [
            'label' => 'جداول النسخ الاحتياطي',
            'permissions' => [
                'backup-schedule-list' => 'عرض الجداول',
                'backup-schedule-create' => 'إنشاء جدول',
                'backup-schedule-edit' => 'تعديل جدول',
                'backup-schedule-delete' => 'حذف جدول',
                'backup-schedule-execute' => 'تنفيذ جدول يدوياً',
            ],
        ],
        'backup_settings' => [
            'label' => 'إعدادات النسخ الاحتياطي',
            'permissions' => [
                'backup-settings-view' => 'عرض إعدادات النسخ',
                'backup-settings-edit' => 'تعديل إعدادات النسخ',
            ],
        ],
        'backup_storage' => [
            'label' => 'تخزين النسخ الاحتياطي',
            'permissions' => [
                'backup-storage-list' => 'عرض إعدادات التخزين',
                'backup-storage-create' => 'إضافة إعداد تخزين',
                'backup-storage-edit' => 'تعديل إعداد تخزين',
                'backup-storage-delete' => 'حذف إعداد تخزين',
                'backup-storage-test' => 'اختبار اتصال التخزين',
                'backup-storage-analytics' => 'إحصائيات تخزين النسخ',
            ],
        ],
        'ai_settings' => [
            'label' => 'الذكاء الاصطناعي — الإعدادات',
            'permissions' => [
                'ai-settings-view' => 'عرض إعدادات الذكاء الاصطناعي',
                'ai-settings-edit' => 'تعديل إعدادات الذكاء الاصطناعي',
            ],
        ],
        'ai_models' => [
            'label' => 'الذكاء الاصطناعي — الموديلات',
            'permissions' => [
                'ai-model-list' => 'عرض الموديلات',
                'ai-model-create' => 'إضافة موديل',
                'ai-model-edit' => 'تعديل موديل',
                'ai-model-delete' => 'حذف موديل',
                'ai-model-test' => 'اختبار اتصال موديل',
            ],
        ],
        'ai_content' => [
            'label' => 'الذكاء الاصطناعي — المحتوى',
            'permissions' => [
                'ai-content-summarize' => 'تلخيص نص',
                'ai-content-improve' => 'تحسين نص',
                'ai-content-grammar' => 'تدقيق لغوي',
            ],
        ],
        'whatsapp_settings' => [
            'label' => 'واتساب — إعدادات الربط',
            'permissions' => [
                'whatsapp-settings-view' => 'عرض إعدادات واتساب',
                'whatsapp-settings-edit' => 'تعديل إعدادات واتساب',
                'whatsapp-settings-test' => 'اختبار اتصال واتساب',
            ],
        ],
        'whatsapp_messages' => [
            'label' => 'واتساب — الرسائل',
            'permissions' => [
                'whatsapp-message-list' => 'عرض الرسائل',
                'whatsapp-message-send' => 'إرسال رسالة',
                'whatsapp-message-broadcast' => 'بث جماعي',
                'whatsapp-message-show' => 'عرض تفاصيل رسالة',
                'whatsapp-message-retry' => 'إعادة إرسال رسالة',
            ],
        ],
        'whatsapp_web' => [
            'label' => 'واتساب ويب',
            'permissions' => [
                'whatsapp-web-connect' => 'ربط واتساب ويب',
                'whatsapp-web-manage' => 'إدارة جلسة واتساب ويب',
            ],
        ],
        'whatsapp_web_settings' => [
            'label' => 'واتساب ويب — الإعدادات',
            'permissions' => [
                'whatsapp-web-settings-view' => 'عرض إعدادات واتساب ويب',
                'whatsapp-web-settings-edit' => 'تعديل إعدادات واتساب ويب',
                'whatsapp-web-settings-test' => 'اختبار اتصال واتساب ويب',
            ],
        ],
        'legacy' => [
            'label' => 'صلاحيات قديمة (للتوافق)',
            'permissions' => [
                'settings-manage' => 'إدارة الإعدادات (عام)',
                'reports-view' => 'عرض التقارير',
            ],
        ],
        'academic_colleges' => [
            'label' => 'الهيكل الأكاديمي — الكليات',
            'permissions' => [
                'college-list' => 'عرض الكليات',
                'college-create' => 'إنشاء كلية',
                'college-edit' => 'تعديل كلية',
                'college-delete' => 'حذف كلية',
            ],
        ],
        'academic_departments' => [
            'label' => 'الهيكل الأكاديمي — الأقسام',
            'permissions' => [
                'department-list' => 'عرض الأقسام',
                'department-create' => 'إنشاء قسم',
                'department-edit' => 'تعديل قسم',
                'department-delete' => 'حذف قسم',
            ],
        ],
        'academic_programs' => [
            'label' => 'الهيكل الأكاديمي — البرامج',
            'permissions' => [
                'program-list' => 'عرض البرامج',
                'program-create' => 'إنشاء برنامج',
                'program-edit' => 'تعديل برنامج',
                'program-delete' => 'حذف برنامج',
            ],
        ],
        'people_staff' => [
            'label' => 'الأشخاص — الهيئة',
            'permissions' => [
                'staff-list' => 'عرض الهيئة',
                'staff-create' => 'إضافة عضو',
                'staff-edit' => 'تعديل عضو',
                'staff-delete' => 'حذف عضو',
            ],
        ],
        'admission' => [
            'label' => 'القبول والتسجيل',
            'permissions' => [
                'admission-cycle-list' => 'عرض فترات القبول',
                'admission-cycle-create' => 'إنشاء فترة قبول',
                'admission-cycle-edit' => 'تعديل فترة قبول',
                'admission-cycle-delete' => 'حذف فترة قبول',
                'admission-application-list' => 'عرض طلبات القبول',
                'admission-application-show' => 'عرض تفاصيل طلب',
                'admission-application-update' => 'تحديث حالة طلب',
                'admission-application-export' => 'تصدير طلبات القبول',
            ],
        ],
        'homepage' => [
            'label' => 'الصفحة الرئيسية',
            'permissions' => [
                'homepage-list' => 'عرض أقسام الصفحة الرئيسية',
                'homepage-edit' => 'تعديل أقسام الصفحة الرئيسية',
            ],
        ],
        'students' => [
            'label' => 'الطلاب (SIS)',
            'permissions' => [
                'student-list' => 'عرض الطلاب',
                'student-create' => 'إضافة طالب',
                'student-edit' => 'تعديل طالب',
                'student-delete' => 'حذف طالب',
            ],
        ],
        'research_centers' => [
            'label' => 'البحث العلمي — مراكز البحث',
            'permissions' => [
                'research-center-list' => 'عرض مراكز البحث',
                'research-center-create' => 'إنشاء مركز بحث',
                'research-center-edit' => 'تعديل مركز بحث',
                'research-center-delete' => 'حذف مركز بحث',
            ],
        ],
        'library_categories' => [
            'label' => 'المكتبة — التصنيفات',
            'permissions' => [
                'library-category-list' => 'عرض تصنيفات المكتبة',
                'library-category-create' => 'إنشاء تصنيف مكتبة',
                'library-category-edit' => 'تعديل تصنيف مكتبة',
                'library-category-delete' => 'حذف تصنيف مكتبة',
            ],
        ],
        'library_books' => [
            'label' => 'المكتبة — الكتب',
            'permissions' => [
                'library-book-list' => 'عرض كتب المكتبة',
                'library-book-create' => 'إنشاء كتاب',
                'library-book-edit' => 'تعديل كتاب',
                'library-book-delete' => 'حذف كتاب',
            ],
        ],
        'library_settings' => [
            'label' => 'المكتبة — الإعدادات',
            'permissions' => [
                'library-settings-edit' => 'تعديل إعدادات المكتبة',
            ],
        ],
    ],
];
