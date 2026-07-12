<?php

namespace App\Http\Controllers\Student;

use App\Enums\EnrollmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Concerns\ResolvesStudent;
use App\Models\AcademicTerm;
use App\Models\Announcement;
use App\Models\Enrollment;
use App\Models\FeeInvoice;
use App\Models\Grade;
use App\Support\GpaCalculator;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use ResolvesStudent;

    public function index(): View
    {
        $student = $this->student()->load('user');
        $currentTerm = AcademicTerm::current()->first();

        $activeEnrollmentsCount = 0;
        $termGpa = null;

        if ($currentTerm) {
            $activeEnrollmentsCount = Enrollment::query()
                ->where('student_id', $student->id)
                ->active()
                ->whereHas('courseSection', fn ($q) => $q->where('academic_term_id', $currentTerm->id))
                ->count();

            $termGrades = Grade::query()
                ->published()
                ->whereHas('enrollment', function ($q) use ($student, $currentTerm) {
                    $q->where('student_id', $student->id)
                        ->whereHas('courseSection', fn ($q2) => $q2->where('academic_term_id', $currentTerm->id));
                })
                ->with(['enrollment.courseSection.programCourse'])
                ->get();

            $termGpa = GpaCalculator::compute($termGrades);
        }

        $publishedGrades = Grade::query()
            ->published()
            ->whereHas('enrollment', fn ($q) => $q->where('student_id', $student->id))
            ->with(['enrollment.courseSection.programCourse'])
            ->get();

        $cumulativeGpa = GpaCalculator::compute($publishedGrades);
        $gradeAverage = $publishedGrades->avg('total');

        $announcements = Announcement::query()
            ->visibleToStudent($student)
            ->latest('published_at')
            ->limit(3)
            ->get();

        $outstandingBalance = FeeInvoice::query()
            ->where('student_id', $student->id)
            ->get()
            ->sum(fn (FeeInvoice $invoice) => $invoice->remaining());

        $stats = [
            'student_number' => $student->student_number,
            'status' => $student->status,
            'program' => $student->program?->name ?? '—',
            'college' => $student->program?->college?->name ?? '—',
            'enrollment_date' => $student->enrollment_date?->translatedFormat('d F Y') ?? '—',
            'current_term' => $currentTerm?->name ?? '—',
            'active_enrollments' => $activeEnrollmentsCount,
            'term_gpa' => $termGpa !== null ? number_format($termGpa, 2) : '—',
            'cumulative_gpa' => $cumulativeGpa !== null ? number_format($cumulativeGpa, 2) : '—',
            'grade_average' => $gradeAverage !== null ? number_format($gradeAverage, 1) : '—',
            'outstanding_balance' => number_format($outstandingBalance, 2),
        ];

        return view('student.pages.dashboard', [
            'student' => $student,
            'stats' => $stats,
            'announcements' => $announcements,
            'roleLabel' => 'طالب',
        ]);
    }
}
