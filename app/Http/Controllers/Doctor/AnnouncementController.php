<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Doctor\Concerns\AuthorizesDoctorSection;
use App\Models\Announcement;
use App\Models\CourseSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AnnouncementController extends Controller
{
    use AuthorizesDoctorSection;

    public function store(Request $request, CourseSection $section): RedirectResponse
    {
        $this->authorizeSection($section);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'body' => ['required', 'string'],
        ], [
            'title.required' => 'عنوان الإعلان مطلوب.',
            'body.required' => 'نص الإعلان مطلوب.',
        ]);

        Announcement::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'audience' => 'section',
            'course_section_id' => $section->id,
            'published_at' => now(),
            'is_active' => true,
            'created_by' => Auth::id(),
        ]);

        return back()->with('success', 'تم نشر إعلان الشعبة للطلاب.');
    }

    public function destroy(CourseSection $section, Announcement $announcement): RedirectResponse
    {
        $this->authorizeSection($section);
        abort_unless(
            $announcement->course_section_id === $section->id && $announcement->audience === 'section',
            404
        );

        $announcement->delete();

        return back()->with('success', 'تم حذف الإعلان.');
    }
}
