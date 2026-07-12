<?php

namespace App\Http\Controllers\Doctor;

use App\Enums\AttendanceStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Doctor\Concerns\AuthorizesDoctorSection;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\CourseSection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    use AuthorizesDoctorSection;

    public function create(CourseSection $section): View
    {
        $this->authorizeSection($section);

        $section->load('programCourse');

        return view('doctor.pages.attendance.create', [
            'section' => $section,
        ]);
    }

    public function store(Request $request, CourseSection $section): RedirectResponse
    {
        $this->authorizeSection($section);

        $validated = $request->validate([
            'session_date' => ['required', 'date'],
            'title' => ['nullable', 'string', 'max:255'],
            'note' => ['nullable', 'string'],
        ], [
            'session_date.required' => 'تاريخ الجلسة مطلوب.',
        ]);

        $session = AttendanceSession::firstOrCreate(
            [
                'course_section_id' => $section->id,
                'session_date' => $validated['session_date'],
            ],
            [
                'title' => $validated['title'] ?? null,
                'note' => $validated['note'] ?? null,
            ]
        );

        if (! $session->wasRecentlyCreated) {
            $session->update([
                'title' => $validated['title'] ?? $session->title,
                'note' => $validated['note'] ?? $session->note,
            ]);
        }

        $enrollments = $section->enrollments()->where('status', 'enrolled')->get();

        foreach ($enrollments as $enrollment) {
            AttendanceRecord::firstOrCreate(
                [
                    'attendance_session_id' => $session->id,
                    'enrollment_id' => $enrollment->id,
                ],
                ['status' => AttendanceStatus::Present]
            );
        }

        return redirect()
            ->route('doctor.attendance.edit', [$section, $session])
            ->with('success', 'تم إنشاء جلسة الحضور.');
    }

    public function edit(CourseSection $section, AttendanceSession $session): View
    {
        $this->authorizeSection($section);
        abort_unless($session->course_section_id === $section->id, 404);

        $session->load(['records.enrollment.student.user']);
        $section->load('programCourse');

        return view('doctor.pages.attendance.edit', [
            'section' => $section,
            'session' => $session,
            'statuses' => AttendanceStatus::cases(),
        ]);
    }

    public function update(Request $request, CourseSection $section, AttendanceSession $session): RedirectResponse
    {
        $this->authorizeSection($section);
        abort_unless($session->course_section_id === $section->id, 404);

        $validated = $request->validate([
            'records' => ['required', 'array'],
            'records.*.status' => ['required', 'in:present,absent,late,excused'],
        ]);

        foreach ($validated['records'] as $recordId => $data) {
            $record = AttendanceRecord::query()
                ->where('id', $recordId)
                ->where('attendance_session_id', $session->id)
                ->first();

            if ($record) {
                $record->update(['status' => $data['status']]);
            }
        }

        return redirect()
            ->route('doctor.sections.show', $section)
            ->with('success', 'تم حفظ سجل الحضور.');
    }
}
