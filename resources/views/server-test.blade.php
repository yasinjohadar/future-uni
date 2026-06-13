<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>اختبار السيرفر — ياسين جوخدار</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: 'Segoe UI', Tahoma, sans-serif; background: #0d0d1a; color: #e8e8f0; padding: 24px; line-height: 1.6; }
        h1 { color: #E60000; margin-bottom: 8px; }
        .sub { color: #888; margin-bottom: 24px; }
        section { background: #151528; border-radius: 8px; padding: 20px; margin-bottom: 16px; border: 1px solid #2a2a4a; }
        section h2 { margin: 0 0 12px; font-size: 1.1rem; color: #fff; }
        .ok { color: #22c55e; }
        .fail { color: #ef4444; }
        table { width: 100%; border-collapse: collapse; font-size: 0.9rem; }
        th, td { text-align: right; padding: 8px 12px; border-bottom: 1px solid #2a2a4a; }
        th { color: #888; font-weight: 600; }
        .badge { display: inline-block; padding: 2px 10px; border-radius: 20px; font-size: 0.8rem; }
        .badge-ok { background: rgba(34, 197, 94, 0.2); color: #22c55e; }
        .badge-fail { background: rgba(239, 68, 68, 0.2); color: #ef4444; }
        .summary { font-size: 1.2rem; margin-bottom: 24px; padding: 16px; border-radius: 8px; }
        .summary.all-ok { background: rgba(34, 197, 94, 0.15); color: #22c55e; }
        .summary.not-ok { background: rgba(239, 68, 68, 0.15); color: #ef4444; }
        pre { background: #0d0d1a; padding: 12px; border-radius: 6px; overflow-x: auto; font-size: 0.85rem; }
    </style>
</head>
<body>
    <h1>اختبار السيرفر</h1>
    <p class="sub">فحص الإصدارات، قاعدة البيانات، إعدادات ENV، والفرونتند</p>

    @if($all_ok ?? true)
        <div class="summary all-ok">✓ جميع الفحوصات ناجحة</div>
    @else
        <div class="summary not-ok">✗ توجد مشاكل في أحد الفحوصات</div>
    @endif

    <section>
        <h2>PHP</h2>
        <table>
            <tr><th>الحالة</th><td><span class="badge badge-ok">OK</span></td></tr>
            <tr><th>الإصدار</th><td>{{ $php['version'] ?? '-' }}</td></tr>
            <tr><th>الحد الأدنى المطلوب</th><td>{{ $php['min_required'] ?? '8.2' }}</td></tr>
            <tr><th>SAPI</th><td>{{ $php['sapi'] ?? '-' }}</td></tr>
        </table>
    </section>

    <section>
        <h2>Laravel</h2>
        <table>
            <tr><th>الحالة</th><td><span class="badge badge-ok">OK</span></td></tr>
            <tr><th>الإصدار</th><td>{{ $laravel['version'] ?? '-' }}</td></tr>
        </table>
    </section>

    <section>
        <h2>قاعدة البيانات</h2>
        @if($database['ok'] ?? false)
            <table>
                <tr><th>الحالة</th><td><span class="badge badge-ok">OK</span></td></tr>
                <tr><th>السائق</th><td>{{ $database['driver'] ?? '-' }}</td></tr>
                <tr><th>قاعدة البيانات</th><td>{{ $database['database'] ?? '-' }}</td></tr>
                <tr><th>عدد الجداول</th><td>{{ $database['tables_count'] ?? '-' }}</td></tr>
            </table>
        @else
            <p class="fail">فشل الاتصال: {{ $database['error'] ?? 'غير معروف' }}</p>
        @endif
    </section>

    <section>
        <h2>إعدادات ENV</h2>
        <table>
            <tr><th>ملف .env موجود</th><td>{{ ($env['env_file_exists'] ?? false) ? 'نعم' : 'لا' }}</td></tr>
            <tr><th>APP_KEY مضبوط</th><td>{{ ($env['app_key_set'] ?? false) ? 'نعم' : 'لا' }}</td></tr>
        </table>
        @if(!empty($env['values']))
            <h3 style="margin-top:16px;">قيم آمنة (بدون كلمات مرور)</h3>
            <table>
                @foreach($env['values'] as $k => $v)
                <tr><th>{{ $k }}</th><td>{{ $v ?? '<em>null</em>' }}</td></tr>
                @endforeach
            </table>
        @endif
    </section>

    <section>
        <h2>التخزين (Storage)</h2>
        <table>
            <tr><th>الحالة</th><td><span class="badge {{ ($storage['ok'] ?? false) ? 'badge-ok' : 'badge-fail' }}">{{ ($storage['ok'] ?? false) ? 'OK' : 'فشل' }}</span></td></tr>
            <tr><th>مجلد storage قابل للكتابة</th><td>{{ ($storage['storage_writable'] ?? false) ? 'نعم' : 'لا' }}</td></tr>
            <tr><th>الرابط الرمزي public/storage</th><td>{{ ($storage['storage_link_exists'] ?? false) ? 'موجود' : 'غير موجود' }}</td></tr>
        </table>
    </section>

    <section>
        <h2>الفرونتند (Frontend)</h2>
        <table>
            <tr><th>الحالة</th><td><span class="badge {{ ($frontend['ok'] ?? false) ? 'badge-ok' : 'badge-fail' }}">{{ ($frontend['ok'] ?? false) ? 'OK' : 'فشل' }}</span></td></tr>
            <tr><th>ملف CSS</th><td>{{ ($frontend['css_exists'] ?? false) ? 'موجود' : 'غير موجود' }}</td></tr>
            <tr><th>ملف JS</th><td>{{ ($frontend['js_exists'] ?? false) ? 'موجود' : 'غير موجود' }}</td></tr>
            <tr><th>اللوغو</th><td>{{ ($frontend['logo_exists'] ?? false) ? 'موجود' : 'غير موجود' }}</td></tr>
            <tr><th>مسار public</th><td><code>{{ $frontend['public_path'] ?? '-' }}</code></td></tr>
        </table>
    </section>

    <section>
        <h2>إضافات PHP</h2>
        @if($extensions['ok'] ?? true)
            <p class="ok">جميع الإضافات المطلوبة محمّلة.</p>
        @else
            <p class="fail">إضافات ناقصة: {{ implode(', ', $extensions['missing'] ?? []) }}</p>
        @endif
    </section>
</body>
</html>
