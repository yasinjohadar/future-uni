<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Doctor\Concerns\AuthorizesDoctorSection;
use App\Models\CourseSection;
use App\Models\Grade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SectionController extends Controller
{
    use AuthorizesDoctorSection;

    public function index(): View
    {
        $sections = $this->doctorSectionsQuery()
            ->with(['programCourse', 'academicTerm'])
            ->withCount(['enrollments as enrolled_count' => fn ($q) => $q->where('status', 'enrolled')])
            ->orderByDesc('created_at')
            ->get();

        return view('doctor.pages.sections.index', [
            'sections' => $sections,
        ]);
    }

    public function show(Request $request, CourseSection $section): View
    {
        $this->authorizeSection($section);

        $search = trim((string) $request->get('q', ''));

        $section->load(['programCourse', 'academicTerm']);

        $enrollmentsQuery = $section->enrollments()
            ->where('status', 'enrolled')
            ->with(['student.user', 'grade']);

        if ($search !== '') {
            $enrollmentsQuery->whereHas('student', function ($q) use ($search) {
                $q->where('student_number', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        $enrollments = $enrollmentsQuery->get();

        foreach ($enrollments as $enrollment) {
            $enrollment->grade()->firstOrCreate(['enrollment_id' => $enrollment->id]);
        }

        $enrollments->load('grade');

        $attendanceSessions = $section->attendanceSessions()
            ->withCount('records')
            ->latest('session_date')
            ->limit(10)
            ->get();

        $announcements = $section->announcements()
            ->latest('published_at')
            ->limit(5)
            ->get();

        $attendanceSummary = $this->buildAttendanceSummary($section);

        return view('doctor.pages.sections.show', [
            'section' => $section,
            'enrollments' => $enrollments,
            'search' => $search,
            'attendanceSessions' => $attendanceSessions,
            'announcements' => $announcements,
            'attendanceSummary' => $attendanceSummary,
        ]);
    }

    public function publishAllGrades(CourseSection $section): RedirectResponse
    {
        $this->authorizeSection($section);

        $published = 0;

        $grades = Grade::query()
            ->whereNull('published_at')
            ->whereNotNull('total')
            ->whereHas('enrollment', fn ($q) => $q
                ->where('course_section_id', $section->id)
                ->where('status', 'enrolled'))
            ->get();

        foreach ($grades as $grade) {
            $grade->update(['published_at' => now()]);
            $published++;
        }

        return back()->with(
            'success',
            $published > 0
                ? "تم نشر {$published} درجة للطلاب."
                : 'لا توجد درجات جاهزة للنشر.'
        );
    }

    public function export(CourseSection $section): StreamedResponse
    {
        $this->authorizeSection($section);

        $section->load(['programCourse', 'enrollments' => fn ($q) => $q->where('status', 'enrolled'), 'enrollments.student.user', 'enrollments.grade']);

        $filename = sprintf(
            'section-%s-%s.csv',
            $section->programCourse->code ?? 'course',
            $section->section_code
        );

        return response()->streamDownload(function () use ($section) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, ['الرقم الجامعي', 'الاسم', 'البريد', 'منتصف', 'نهائي', 'المجموع', 'التقدير', 'حالة النشر']);

            foreach ($section->enrollments as $enrollment) {
                $grade = $enrollment->grade;
                fputcsv($handle, [
                    $enrollment->student->student_number ?? '',
                    $enrollment->student->user->name ?? '',
                    $enrollment->student->user->email ?? '',
                    $grade?->midterm,
                    $grade?->final,
                    $grade?->total,
                    $grade?->letter,
                    $grade?->isPublished() ? 'منشور' : 'مسودة',
                ]);
            }

            fclose($handle);
        }, $filename, [
            'Content-Type' => 'text/csv; charset=UTF-8',
        ]);
    }

    protected function buildAttendanceSummary(CourseSection $section): array
    {
        $sessionsCount = $section->attendanceSessions()->count();

        if ($sessionsCount === 0) {
            return [];
        }

        $summary = [];

        $enrollments = $section->enrollments()->where('status', 'enrolled')->with('student.user')->get();

        foreach ($enrollments as $enrollment) {
            $present = $enrollment->attendanceRecords()
                ->whereIn('status', ['present', 'late', 'excused'])
                ->whereHas('session', fn ($q) => $q->where('course_section_id', $section->id))
                ->count();

            $summary[$enrollment->id] = [
                'present' => $present,
                'total' => $sessionsCount,
                'percent' => round(($present / $sessionsCount) * 100, 1),
            ];
        }

        return $summary;
    }
}
