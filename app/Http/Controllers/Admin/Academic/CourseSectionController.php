<?php

namespace App\Http\Controllers\Admin\Academic;

use App\Http\Controllers\Admin\Concerns\GeneratesArabicSlug;
use App\Http\Controllers\Controller;
use App\Models\AcademicTerm;
use App\Models\CourseSection;
use App\Models\ProgramCourse;
use App\Models\StaffMember;
use App\Models\User;
use Illuminate\Http\Request;

class CourseSectionController extends Controller
{
    use GeneratesArabicSlug;

    public function index(Request $request)
    {
        $query = CourseSection::with(['programCourse.program', 'academicTerm', 'staffMember', 'instructor']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('section_code', 'like', "%{$search}%")
                    ->orWhere('room', 'like', "%{$search}%")
                    ->orWhereHas('programCourse', fn ($pc) => $pc->where('name', 'like', "%{$search}%")->orWhere('code', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('academic_term_id')) {
            $query->where('academic_term_id', $request->academic_term_id);
        }

        if ($request->filled('program_course_id')) {
            $query->where('program_course_id', $request->program_course_id);
        }

        $filteredCount = (clone $query)->count();
        $sections = $query->latest()->paginate(20)->withQueryString();
        $terms = AcademicTerm::orderByDesc('starts_at')->get();
        $programCourses = ProgramCourse::with('program')->orderBy('name')->get();

        $stats = [
            'total' => CourseSection::count(),
            'active' => CourseSection::where('is_active', true)->count(),
            'filtered' => $filteredCount,
        ];

        return view('admin.academic.sections.index', compact('sections', 'terms', 'programCourses', 'stats'));
    }

    public function create(Request $request)
    {
        return view('admin.academic.sections.create', $this->formData($request));
    }

    public function show(CourseSection $course_section)
    {
        return redirect()->route('admin.academic.sections.edit', $course_section);
    }

    public function store(Request $request)
    {
        $validated = $this->validateSection($request);
        $validated['is_active'] = $this->resolveIsActive($request);
        $validated['days'] = $this->normalizeDays($request);

        CourseSection::create($validated);

        return redirect()->route('admin.academic.sections.index')
            ->with('success', 'تم إنشاء الشعبة بنجاح');
    }

    public function edit(CourseSection $course_section)
    {
        return view('admin.academic.sections.edit', array_merge(
            ['section' => $course_section],
            $this->formData(request())
        ));
    }

    public function update(Request $request, CourseSection $course_section)
    {
        $validated = $this->validateSection($request, $course_section->id);
        $validated['is_active'] = $this->resolveIsActive($request);
        $validated['days'] = $this->normalizeDays($request);

        $course_section->update($validated);

        return redirect()->route('admin.academic.sections.index')
            ->with('success', 'تم تحديث الشعبة بنجاح');
    }

    public function destroy(CourseSection $course_section)
    {
        if ($course_section->enrollments()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف الشعبة لأنها مرتبطة بتسجيلات.');
        }

        $course_section->delete();

        return redirect()->route('admin.academic.sections.index')
            ->with('success', 'تم حذف الشعبة بنجاح');
    }

    private function formData(Request $request): array
    {
        return [
            'programCourses' => ProgramCourse::with('program')->orderBy('name')->get(),
            'terms' => AcademicTerm::orderByDesc('starts_at')->get(),
            'staffMembers' => StaffMember::active()->ordered()->get(),
            'doctors' => User::role('doctor')->orderBy('name')->get(),
            'dayLabels' => CourseSection::DAY_LABELS,
            'selectedProgramCourseId' => $request->get('program_course_id'),
            'selectedTermId' => $request->get('academic_term_id'),
        ];
    }

    private function validateSection(Request $request, ?int $ignoreId = null): array
    {
        $request->merge([
            'staff_member_id' => $request->input('staff_member_id') ?: null,
            'instructor_user_id' => $request->input('instructor_user_id') ?: null,
        ]);

        $uniqueRule = 'unique:course_sections,section_code,NULL,id,program_course_id,' . $request->input('program_course_id') . ',academic_term_id,' . $request->input('academic_term_id');
        if ($ignoreId) {
            $uniqueRule = 'unique:course_sections,section_code,' . $ignoreId . ',id,program_course_id,' . $request->input('program_course_id') . ',academic_term_id,' . $request->input('academic_term_id');
        }

        return $request->validate([
            'program_course_id' => 'required|exists:program_courses,id',
            'academic_term_id' => 'required|exists:academic_terms,id',
            'staff_member_id' => 'nullable|exists:staff_members,id',
            'instructor_user_id' => 'nullable|exists:users,id',
            'section_code' => 'required|string|max:20|' . $uniqueRule,
            'capacity' => 'nullable|integer|min:1|max:500',
            'days' => 'nullable|array',
            'days.*' => 'integer|min:0|max:6',
            'starts_at' => 'nullable|date_format:H:i',
            'ends_at' => 'nullable|date_format:H:i',
            'room' => 'nullable|string|max:100',
            'is_active' => 'boolean',
        ], [
            'program_course_id.required' => 'المقرر مطلوب.',
            'academic_term_id.required' => 'الفصل الدراسي مطلوب.',
            'section_code.required' => 'رمز الشعبة مطلوب.',
            'section_code.unique' => 'رمز الشعبة موجود مسبقاً لهذا المقرر والفصل.',
        ]);
    }

    private function normalizeDays(Request $request): array
    {
        return collect($request->input('days', []))
            ->map(fn ($day) => (int) $day)
            ->unique()
            ->sort()
            ->values()
            ->all();
    }
}
