<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Doctor\Concerns\AuthorizesDoctorSection;
use App\Models\AcademicTerm;
use App\Models\Enrollment;
use App\Models\Grade;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    use AuthorizesDoctorSection;

    public function index(): View
    {
        $user = Auth::user();
        $currentTerm = AcademicTerm::current()->first();

        $sectionsQuery = $this->doctorSectionsQuery()->with(['programCourse', 'academicTerm']);

        if ($currentTerm) {
            $sectionsQuery->where('academic_term_id', $currentTerm->id);
        }

        $sections = $sectionsQuery
            ->withCount(['enrollments as enrolled_count' => fn ($q) => $q->where('status', 'enrolled')])
            ->orderBy('starts_at')
            ->get();

        $studentsCount = Enrollment::query()
            ->where('status', 'enrolled')
            ->whereHas('courseSection', fn ($q) => $q->where('instructor_user_id', $user->id)
                ->when($currentTerm, fn ($q2) => $q2->where('academic_term_id', $currentTerm->id)))
            ->distinct('student_id')
            ->count('student_id');

        $unpublishedGrades = Grade::query()
            ->whereNull('published_at')
            ->whereNotNull('total')
            ->whereHas('enrollment.courseSection', fn ($q) => $q->where('instructor_user_id', $user->id)
                ->when($currentTerm, fn ($q2) => $q2->where('academic_term_id', $currentTerm->id)))
            ->count();

        $stats = [
            'name' => $user->name,
            'email' => $user->email,
            'role' => 'دكتور',
            'current_term' => $currentTerm?->name ?? '—',
            'sections_count' => $sections->count(),
            'students_count' => $studentsCount,
            'unpublished_grades' => $unpublishedGrades,
        ];

        return view('doctor.pages.dashboard', [
            'stats' => $stats,
            'sections' => $sections,
            'currentTerm' => $currentTerm,
            'roleLabel' => 'دكتور',
        ]);
    }
}
