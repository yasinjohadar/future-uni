<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Doctor\Concerns\AuthorizesDoctorSection;
use App\Models\AcademicTerm;
use App\Models\CourseSection;
use Illuminate\View\View;

class ScheduleController extends Controller
{
    use AuthorizesDoctorSection;

    public function index(): View
    {
        $currentTerm = AcademicTerm::current()->first();

        $grid = collect(CourseSection::DAY_LABELS)->mapWithKeys(fn ($label, $day) => [
            $day => ['label' => $label, 'slots' => collect()],
        ]);

        if ($currentTerm) {
            $sections = $this->doctorSectionsQuery()
                ->active()
                ->where('academic_term_id', $currentTerm->id)
                ->with('programCourse')
                ->get();

            foreach ($sections as $section) {
                foreach ($section->days ?? [] as $day) {
                    $day = (int) $day;
                    if ($grid->has($day)) {
                        $grid[$day]['slots']->push($section);
                    }
                }
            }
        }

        return view('doctor.pages.schedule.index', [
            'currentTerm' => $currentTerm,
            'grid' => $grid,
        ]);
    }
}
