<?php

namespace App\Http\Controllers\Admin\Academic;

use App\Http\Controllers\Admin\Concerns\GeneratesArabicSlug;
use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\College;
use App\Models\Program;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    use GeneratesArabicSlug;

    public function index(Request $request)
    {
        $query = Announcement::with(['college', 'program', 'creator']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('body', 'like', "%{$search}%");
            });
        }

        if ($request->filled('audience')) {
            $query->where('audience', $request->audience);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $filteredCount = (clone $query)->count();
        $announcements = $query->latest()->paginate(20)->withQueryString();

        $stats = [
            'total' => Announcement::count(),
            'active' => Announcement::where('is_active', true)->count(),
            'filtered' => $filteredCount,
        ];

        return view('admin.academic.announcements.index', compact('announcements', 'stats'));
    }

    public function create()
    {
        return view('admin.academic.announcements.create', [
            'colleges' => College::ordered()->get(),
            'programs' => Program::active()->ordered()->get(),
        ]);
    }

    public function show(Announcement $announcement)
    {
        return redirect()->route('admin.academic.announcements.edit', $announcement);
    }

    public function store(Request $request)
    {
        $validated = $this->validateAnnouncement($request);
        $validated['is_active'] = $this->resolveIsActive($request);
        $validated['created_by'] = auth()->id();
        $validated['published_at'] = $request->filled('publish_now') ? now() : ($validated['published_at'] ?? null);

        Announcement::create($validated);

        return redirect()->route('admin.academic.announcements.index')
            ->with('success', 'تم إنشاء الإعلان بنجاح');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.academic.announcements.edit', [
            'announcement' => $announcement,
            'colleges' => College::ordered()->get(),
            'programs' => Program::active()->ordered()->get(),
        ]);
    }

    public function update(Request $request, Announcement $announcement)
    {
        $validated = $this->validateAnnouncement($request);
        $validated['is_active'] = $this->resolveIsActive($request);

        if ($request->filled('publish_now')) {
            $validated['published_at'] = now();
        }

        $announcement->update($validated);

        return redirect()->route('admin.academic.announcements.index')
            ->with('success', 'تم تحديث الإعلان بنجاح');
    }

    public function destroy(Announcement $announcement)
    {
        $announcement->delete();

        return redirect()->route('admin.academic.announcements.index')
            ->with('success', 'تم حذف الإعلان بنجاح');
    }

    private function validateAnnouncement(Request $request): array
    {
        $request->merge([
            'college_id' => $request->input('college_id') ?: null,
            'program_id' => $request->input('program_id') ?: null,
        ]);

        return $request->validate([
            'title' => 'required|string|max:255',
            'body' => 'required|string',
            'audience' => 'required|in:all,college,program',
            'college_id' => 'nullable|required_if:audience,college|exists:colleges,id',
            'program_id' => 'nullable|required_if:audience,program|exists:programs,id',
            'published_at' => 'nullable|date',
            'is_active' => 'boolean',
        ], [
            'title.required' => 'عنوان الإعلان مطلوب.',
            'body.required' => 'نص الإعلان مطلوب.',
            'audience.required' => 'الجمهور المستهدف مطلوب.',
        ]);
    }
}
