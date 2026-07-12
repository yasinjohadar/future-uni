<?php

namespace App\Http\Controllers\Student;

use App\Enums\EnrollmentStatus;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Concerns\ResolvesStudent;
use App\Models\AcademicTerm;
use App\Models\CourseSection;
use App\Models\Enrollment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegistrationController extends Controller
{
    use ResolvesStudent;

    public function index(): View
    {
        $student = $this->student();
        $currentTerm = AcademicTerm::current()->first();
        $registrationOpen = $currentTerm?->isRegistrationOpen() ?? false;

        $currentEnrollments = collect();
        $availableSections = collect();

        if ($currentTerm) {
            $currentEnrollments = Enrollment::query()
                ->where('student_id', $student->id)
                ->where('status', EnrollmentStatus::Enrolled)
                ->whereHas('courseSection', fn ($q) => $q->where('academic_term_id', $currentTerm->id))
                ->with(['courseSection.programCourse'])
                ->get();

            if ($registrationOpen) {
                $enrolledSectionIds = $currentEnrollments->pluck('course_section_id');
                $enrolledCourseIds = $currentEnrollments
                    ->map(fn (Enrollment $e) => $e->courseSection?->program_course_id)
                    ->filter()
                    ->unique()
                    ->values();

                $availableSections = CourseSection::query()
                    ->active()
                    ->where('academic_term_id', $currentTerm->id)
                    ->whereNotIn('id', $enrolledSectionIds)
                    ->when($enrolledCourseIds->isNotEmpty(), fn ($q) => $q->whereNotIn('program_course_id', $enrolledCourseIds))
                    ->with(['programCourse', 'instructor', 'staffMember'])
                    ->get()
                    ->filter(fn (CourseSection $section) => $section->hasCapacity());
            }
        }

        return view('student.pages.registration.index', [
            'student' => $student,
            'currentTerm' => $currentTerm,
            'registrationOpen' => $registrationOpen,
            'availableSections' => $availableSections,
            'currentEnrollments' => $currentEnrollments,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $student = $this->student();
        $currentTerm = AcademicTerm::current()->first();

        if (! $currentTerm || ! $currentTerm->isRegistrationOpen()) {
            return back()->with('error', 'التسجيل مغلق حالياً.');
        }

        $validated = $request->validate([
            'course_section_id' => ['required', 'integer', 'exists:course_sections,id'],
        ]);

        $section = CourseSection::query()
            ->active()
            ->where('academic_term_id', $currentTerm->id)
            ->findOrFail($validated['course_section_id']);

        if (! $section->hasCapacity()) {
            return back()->with('error', 'الشعبة ممتلئة.');
        }

        $alreadyEnrolled = Enrollment::query()
            ->where('student_id', $student->id)
            ->where('status', EnrollmentStatus::Enrolled)
            ->where(function ($q) use ($section) {
                $q->where('course_section_id', $section->id)
                    ->orWhereHas('courseSection', fn ($q2) => $q2
                        ->where('academic_term_id', $section->academic_term_id)
                        ->where('program_course_id', $section->program_course_id));
            })
            ->exists();

        if ($alreadyEnrolled) {
            return back()->with('error', 'أنت مسجّل في هذا المقرر مسبقاً.');
        }

        Enrollment::create([
            'student_id' => $student->id,
            'course_section_id' => $section->id,
            'status' => EnrollmentStatus::Enrolled,
            'enrolled_at' => now(),
        ]);

        return redirect()
            ->route('student.registration.index')
            ->with('success', 'تم التسجيل في المقرر بنجاح.');
    }

    public function destroy(Enrollment $enrollment): RedirectResponse
    {
        $student = $this->student();

        if ($enrollment->student_id !== $student->id) {
            abort(403);
        }

        $currentTerm = AcademicTerm::current()->first();

        if (! $currentTerm || ! $currentTerm->isRegistrationOpen()) {
            return back()->with('error', 'لا يمكن إسقاط المقرر — التسجيل مغلق.');
        }

        if ($enrollment->courseSection->academic_term_id !== $currentTerm->id) {
            return back()->with('error', 'لا يمكن إسقاط مقرر من فصل سابق.');
        }

        $enrollment->update(['status' => EnrollmentStatus::Dropped]);

        return redirect()
            ->route('student.registration.index')
            ->with('success', 'تم إسقاط المقرر بنجاح.');
    }
}
