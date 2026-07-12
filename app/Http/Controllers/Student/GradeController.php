<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Concerns\ResolvesStudent;
use App\Models\AcademicTerm;
use App\Models\Grade;
use App\Support\GpaCalculator;
use Illuminate\View\View;

class GradeController extends Controller
{
    use ResolvesStudent;

    public function index(): View
    {
        $student = $this->student();
        $currentTerm = AcademicTerm::current()->first();

        $grades = Grade::query()
            ->published()
            ->whereHas('enrollment', fn ($q) => $q->where('student_id', $student->id))
            ->with([
                'enrollment.courseSection.programCourse',
                'enrollment.courseSection.academicTerm',
            ])
            ->orderByDesc('published_at')
            ->get();

        $termGrades = $currentTerm
            ? $grades->filter(fn (Grade $grade) => $grade->enrollment->courseSection->academic_term_id === $currentTerm->id)
            : collect();

        $termGpa = GpaCalculator::compute($termGrades);
        $cumulativeGpa = GpaCalculator::compute($grades);

        return view('student.pages.grades.index', [
            'student' => $student,
            'currentTerm' => $currentTerm,
            'grades' => $grades,
            'termGpa' => $termGpa,
            'cumulativeGpa' => $cumulativeGpa,
        ]);
    }
}
