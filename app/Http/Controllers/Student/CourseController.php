<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Concerns\ResolvesStudent;
use App\Models\AcademicTerm;
use App\Models\Enrollment;
use Illuminate\View\View;

class CourseController extends Controller
{
    use ResolvesStudent;

    public function index(): View
    {
        $student = $this->student();
        $currentTerm = AcademicTerm::current()->first();

        $enrollments = collect();

        if ($currentTerm) {
            $enrollments = Enrollment::query()
                ->where('student_id', $student->id)
                ->active()
                ->whereHas('courseSection', fn ($q) => $q->where('academic_term_id', $currentTerm->id))
                ->with([
                    'courseSection.programCourse',
                    'courseSection.instructor',
                    'courseSection.staffMember',
                    'grade',
                ])
                ->get();
        }

        return view('student.pages.courses.index', [
            'student' => $student,
            'currentTerm' => $currentTerm,
            'enrollments' => $enrollments,
        ]);
    }
}
