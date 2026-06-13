<?php

namespace App\Http\Controllers\Admin\Academic;

use App\Enums\ProgramLevel;
use App\Http\Controllers\Admin\Concerns\GeneratesArabicSlug;
use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Department;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProgramController extends Controller
{
    use GeneratesArabicSlug;

    public function index(Request $request)
    {
        $query = Program::with(['college', 'department']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('college_id')) {
            $query->where('college_id', $request->college_id);
        }

        if ($request->filled('department_id')) {
            $query->where('department_id', $request->department_id);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $filteredCount = (clone $query)->count();
        $programs = $query->orderBy('sort_order')->orderBy('name')->paginate(20)->withQueryString();
        $colleges = College::ordered()->get();
        $levels = ProgramLevel::cases();

        $stats = [
            'total' => Program::count(),
            'active' => Program::where('is_active', true)->count(),
            'inactive' => Program::where('is_active', false)->count(),
            'filtered' => $filteredCount,
        ];

        return view('admin.academic.programs.index', compact('programs', 'colleges', 'levels', 'stats'));
    }

    public function create(Request $request)
    {
        $colleges = College::ordered()->get();
        $departments = Department::when($request->college_id, fn ($q) => $q->where('college_id', $request->college_id))->ordered()->get();
        $levels = ProgramLevel::cases();
        $selectedCollegeId = $request->get('college_id');
        $selectedDepartmentId = $request->get('department_id');

        return view('admin.academic.programs.create', compact('colleges', 'departments', 'levels', 'selectedCollegeId', 'selectedDepartmentId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'department_id' => 'nullable|exists:departments,id',
            'name' => 'required|string|max:255|unique:programs,name',
            'level' => ['required', Rule::enum(ProgramLevel::class)],
            'duration' => 'nullable|string|max:100',
            'credits' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'college_id.required' => 'الكلية مطلوبة.',
            'name.required' => 'اسم البرنامج مطلوب.',
            'name.unique' => 'اسم البرنامج موجود مسبقاً.',
            'level.required' => 'المستوى الأكاديمي مطلوب.',
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['name'], Program::class);
        $validated['is_active'] = $this->resolveIsActive($request);
        $validated['sort_order'] = $validated['sort_order'] ?? ((Program::max('sort_order') ?? 0) + 1);

        Program::create($validated);

        return redirect()->route('admin.academic.programs.index')
            ->with('success', 'تم إنشاء البرنامج بنجاح');
    }

    public function show(Program $program)
    {
        $program->load([
            'college',
            'department',
            'courses' => fn ($q) => $q->orderBy('sort_order'),
        ]);

        return view('admin.academic.programs.show', compact('program'));
    }

    public function edit(Program $program)
    {
        $program->load(['college', 'department'])->loadCount('courses');
        $colleges = College::ordered()->get();
        $departments = Department::where('college_id', $program->college_id)->ordered()->get();
        $levels = ProgramLevel::cases();

        return view('admin.academic.programs.edit', compact('program', 'colleges', 'departments', 'levels'));
    }

    public function update(Request $request, Program $program)
    {
        $validated = $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'department_id' => 'nullable|exists:departments,id',
            'name' => 'required|string|max:255|unique:programs,name,' . $program->id,
            'level' => ['required', Rule::enum(ProgramLevel::class)],
            'duration' => 'nullable|string|max:100',
            'credits' => 'nullable|integer|min:0',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'college_id.required' => 'الكلية مطلوبة.',
            'name.required' => 'اسم البرنامج مطلوب.',
            'name.unique' => 'اسم البرنامج موجود مسبقاً.',
            'level.required' => 'المستوى الأكاديمي مطلوب.',
        ]);

        $validated['is_active'] = $this->resolveIsActive($request);

        if ($validated['name'] !== $program->name) {
            $validated['slug'] = $this->generateUniqueSlug($validated['name'], Program::class, $program->id);
        }

        $program->update($validated);

        return redirect()->route('admin.academic.programs.index')
            ->with('success', 'تم تحديث البرنامج بنجاح');
    }

    public function destroy(Program $program)
    {
        if ($program->admissionApplications()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف البرنامج لأنه مرتبط بطلبات قبول.');
        }

        $program->delete();

        return redirect()->route('admin.academic.programs.index')
            ->with('success', 'تم حذف البرنامج بنجاح');
    }

    public function toggleActive(Program $program)
    {
        $program->update(['is_active' => ! $program->is_active]);

        return back()->with('success', 'تم تحديث حالة البرنامج');
    }
}
