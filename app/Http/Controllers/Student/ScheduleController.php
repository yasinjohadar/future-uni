<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Concerns\ResolvesStudent;
use App\Models\AcademicTerm;
use App\Models\CourseSection;
use App\Models\Enrollment;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    use ResolvesStudent;

    public function index(): View
    {
        $student = $this->student();
        $currentTerm = AcademicTerm::current()->first();

        $grid = collect(CourseSection::DAY_LABELS)->mapWithKeys(fn ($label, $day) => [
            $day => ['label' => $label, 'slots' => collect()],
        ]);

        if ($currentTerm) {
            $sections = Enrollment::query()
                ->where('student_id', $student->id)
                ->active()
                ->whereHas('courseSection', fn ($q) => $q->where('academic_term_id', $currentTerm->id))
                ->with(['courseSection.programCourse'])
                ->get()
                ->pluck('courseSection')
                ->filter();

            foreach ($sections as $section) {
                foreach ($section->days ?? [] as $day) {
                    $day = (int) $day;
                    if ($grid->has($day)) {
                        $grid[$day]['slots']->push($section);
                    }
                }
            }
        }

        return view('student.pages.schedule.index', [
            'student' => $student,
            'currentTerm' => $currentTerm,
            'grid' => $grid,
        ]);
    }
}
