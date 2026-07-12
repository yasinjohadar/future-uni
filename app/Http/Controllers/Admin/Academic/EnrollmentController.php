<?php

namespace App\Http\Controllers\Admin\Academic;

use App\Enums\EnrollmentStatus;
use App\Http\Controllers\Controller;
use App\Models\CourseSection;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::with([
            'student.user',
            'student.program',
            'courseSection.programCourse',
            'courseSection.academicTerm',
            'grade',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('student', function ($q) use ($search) {
                $q->where('student_number', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('course_section_id')) {
            $query->where('course_section_id', $request->course_section_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $filteredCount = (clone $query)->count();
        $enrollments = $query->latest('enrolled_at')->paginate(20)->withQueryString();
        $sections = CourseSection::with('programCourse')->latest()->limit(100)->get();
        $statuses = EnrollmentStatus::cases();

        $stats = [
            'total' => Enrollment::count(),
            'enrolled' => Enrollment::where('status', EnrollmentStatus::Enrolled)->count(),
            'filtered' => $filteredCount,
        ];

        return view('admin.academic.enrollments.index', compact('enrollments', 'sections', 'statuses', 'stats'));
    }

    public function create(Request $request)
    {
        $students = Student::with('user')->latest()->limit(200)->get();
        $sections = CourseSection::with(['programCourse', 'academicTerm'])->active()->latest()->get();
        $statuses = EnrollmentStatus::cases();
        $selectedSectionId = $request->get('course_section_id');
        $selectedStudentId = $request->get('student_id');

        return view('admin.academic.enrollments.create', compact('students', 'sections', 'statuses', 'selectedSectionId', 'selectedStudentId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'course_section_id' => 'required|exists:course_sections,id',
            'status' => ['required', Rule::enum(EnrollmentStatus::class)],
            'enrolled_at' => 'nullable|date',
        ], [
            'student_id.required' => 'الطالب مطلوب.',
            'course_section_id.required' => 'الشعبة مطلوبة.',
            'status.required' => 'حالة التسجيل مطلوبة.',
        ]);

        $exists = Enrollment::where('student_id', $validated['student_id'])
            ->where('course_section_id', $validated['course_section_id'])
            ->exists();

        if ($exists) {
            return back()->withInput()->with('error', 'الطالب مسجّل مسبقاً في هذه الشعبة.');
        }

        $validated['enrolled_at'] = $validated['enrolled_at'] ?? now();

        Enrollment::create($validated);

        return redirect()->route('admin.academic.enrollments.index')
            ->with('success', 'تم إنشاء التسجيل بنجاح');
    }

    public function show(Enrollment $enrollment)
    {
        $enrollment->load([
            'student.user',
            'student.program',
            'courseSection.programCourse.program',
            'courseSection.academicTerm',
            'courseSection.staffMember',
            'grade',
        ]);

        return view('admin.academic.enrollments.show', compact('enrollment'));
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->grade?->delete();
        $enrollment->delete();

        return redirect()->route('admin.academic.enrollments.index')
            ->with('success', 'تم حذف التسجيل بنجاح');
    }

    public function updateGrade(Request $request, Enrollment $enrollment)
    {
        $validated = $request->validate([
            'midterm' => 'nullable|numeric|min:0|max:100',
            'final' => 'nullable|numeric|min:0|max:100',
        ], [
            'midterm.numeric' => 'درجة منتصف الفصل يجب أن تكون رقماً.',
            'final.numeric' => 'درجة نهاية الفصل يجب أن تكون رقماً.',
        ]);

        $grade = Grade::updateOrCreate(
            ['enrollment_id' => $enrollment->id],
            [
                'midterm' => $validated['midterm'] ?? null,
                'final' => $validated['final'] ?? null,
            ]
        );

        $grade->recalculate();
        $grade->save();

        return back()->with('success', 'تم تحديث الدرجات بنجاح');
    }

    public function publishGrade(Enrollment $enrollment)
    {
        $grade = $enrollment->grade;

        if ($grade) {
            $grade->published_at = now();
            $grade->save();
        }

        return back()->with('success', 'تم نشر الدرجة بنجاح');
    }

    public function unpublishGrade(Enrollment $enrollment)
    {
        $grade = $enrollment->grade;

        if ($grade) {
            $grade->published_at = null;
            $grade->save();
        }

        return back()->with('success', 'تم إلغاء نشر الدرجة');
    }
}
