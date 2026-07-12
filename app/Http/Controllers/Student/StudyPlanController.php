<?php

namespace App\Http\Controllers\Student;

use App\Enums\EnrollmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Concerns\ResolvesStudent;
use App\Models\AcademicTerm;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\ProgramCourse;
use Illuminate\View\View;

class StudyPlanController extends Controller
{
    use ResolvesStudent;

    public function index(): View
    {
        $student = $this->student();
        $currentTerm = AcademicTerm::current()->first();

        $programCourses = ProgramCourse::query()
            ->where('program_id', $student->program_id)
            ->orderBy('semester')
            ->orderBy('sort_order')
            ->orderBy('code')
            ->get();

        $completedCourseIds = Grade::query()
            ->published()
            ->whereHas('enrollment', fn ($q) => $q->where('student_id', $student->id))
            ->where('letter', '!=', 'F')
            ->whereNotNull('letter')
            ->with('enrollment.courseSection')
            ->get()
            ->pluck('enrollment.courseSection.program_course_id')
            ->filter()
            ->unique();

        $enrolledCourseIds = collect();

        if ($currentTerm) {
            $enrolledCourseIds = Enrollment::query()
                ->where('student_id', $student->id)
                ->where('status', EnrollmentStatus::Enrolled)
                ->whereHas('courseSection', fn ($q) => $q->where('academic_term_id', $currentTerm->id))
                ->with('courseSection')
                ->get()
                ->pluck('courseSection.program_course_id')
                ->filter()
                ->unique();
        }

        $courses = $programCourses->map(function (ProgramCourse $course) use ($completedCourseIds, $enrolledCourseIds) {
            $status = 'remaining';

            if ($completedCourseIds->contains($course->id)) {
                $status = 'completed';
            } elseif ($enrolledCourseIds->contains($course->id)) {
                $status = 'enrolled';
            }

            return (object) [
                'course' => $course,
                'status' => $status,
            ];
        });

        $statusCounts = [
            'completed' => $courses->where('status', 'completed')->count(),
            'enrolled' => $courses->where('status', 'enrolled')->count(),
            'remaining' => $courses->where('status', 'remaining')->count(),
        ];

        return view('student.pages.study-plan.index', [
            'student' => $student,
            'courses' => $courses,
            'statusCounts' => $statusCounts,
        ]);
    }
}
