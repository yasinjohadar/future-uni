<?php

namespace App\Http\Controllers\Admin\Library;

use App\Http\Controllers\Controller;
use App\Models\LibrarySetting;
use Illuminate\Http\Request;

class LibrarySettingController extends Controller
{
    public function edit()
    {
        return view('admin.library.settings.edit', [
            'settings' => LibrarySetting::instance(),
        ]);
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'digital_references' => 'required|string|max:50',
            'reading_seats' => 'required|integer|min:0',
        ], [
            'digital_references.required' => 'قيمة المراجع الرقمية مطلوبة.',
            'reading_seats.required' => 'عدد مقاعد المطالعة مطلوب.',
        ]);

        LibrarySetting::instance()->update($validated);

        return redirect()->route('admin.library.settings.edit')
            ->with('success', 'تم تحديث إعدادات المكتبة بنجاح');
    }
}
