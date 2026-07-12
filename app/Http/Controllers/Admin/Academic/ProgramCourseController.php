<?php

namespace App\Http\Controllers\Admin\Academic;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramCourse;
use Illuminate\Http\Request;

class ProgramCourseController extends Controller
{
    public function index(Request $request)
    {
        $query = ProgramCourse::with('program');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        $filteredCount = (clone $query)->count();
        $courses = $query->orderBy('sort_order')->orderBy('name')->paginate(20)->withQueryString();
        $programs = Program::active()->ordered()->get();

        $stats = [
            'total' => ProgramCourse::count(),
            'filtered' => $filteredCount,
        ];

        return view('admin.academic.program-courses.index', compact('courses', 'programs', 'stats'));
    }

    public function create(Request $request)
    {
        $programs = Program::active()->ordered()->get();
        $selectedProgramId = $request->get('program_id');

        return view('admin.academic.program-courses.create', compact('programs', 'selectedProgramId'));
    }

    public function show(ProgramCourse $program_course)
    {
        return redirect()->route('admin.academic.program-courses.edit', $program_course);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'credits' => 'nullable|integer|min:1|max:30',
            'semester' => 'nullable|integer|min:1|max:20',
            'type' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
        ], [
            'program_id.required' => 'البرنامج مطلوب.',
            'code.required' => 'رمز المقرر مطلوب.',
            'name.required' => 'اسم المقرر مطلوب.',
        ]);

        $validated['credits'] = $validated['credits'] ?? 3;
        $validated['type'] = $validated['type'] ?? 'core';
        $validated['sort_order'] = $validated['sort_order'] ?? ((ProgramCourse::where('program_id', $validated['program_id'])->max('sort_order') ?? 0) + 1);

        ProgramCourse::create($validated);

        return redirect()->route('admin.academic.program-courses.index', ['program_id' => $validated['program_id']])
            ->with('success', 'تم إنشاء المقرر بنجاح');
    }

    public function edit(ProgramCourse $program_course)
    {
        $programs = Program::active()->ordered()->get();

        return view('admin.academic.program-courses.edit', [
            'course' => $program_course,
            'programs' => $programs,
        ]);
    }

    public function update(Request $request, ProgramCourse $program_course)
    {
        $validated = $request->validate([
            'program_id' => 'required|exists:programs,id',
            'code' => 'required|string|max:50',
            'name' => 'required|string|max:255',
            'credits' => 'nullable|integer|min:1|max:30',
            'semester' => 'nullable|integer|min:1|max:20',
            'type' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer|min:0',
        ], [
            'program_id.required' => 'البرنامج مطلوب.',
            'code.required' => 'رمز المقرر مطلوب.',
            'name.required' => 'اسم المقرر مطلوب.',
        ]);

        $validated['type'] = $validated['type'] ?? 'core';

        $program_course->update($validated);

        return redirect()->route('admin.academic.program-courses.index', ['program_id' => $validated['program_id']])
            ->with('success', 'تم تحديث المقرر بنجاح');
    }

    public function destroy(ProgramCourse $program_course)
    {
        if ($program_course->sections()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف المقرر لأنه مرتبط بشعب دراسية.');
        }

        $program_course->delete();

        return redirect()->route('admin.academic.program-courses.index')
            ->with('success', 'تم حذف المقرر بنجاح');
    }
}
