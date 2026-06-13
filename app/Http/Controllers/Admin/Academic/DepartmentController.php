<?php

namespace App\Http\Controllers\Admin\Academic;

use App\Http\Controllers\Admin\Concerns\GeneratesArabicSlug;
use App\Http\Controllers\Concerns\RespondsWithAjaxTable;
use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    use GeneratesArabicSlug;
    use RespondsWithAjaxTable;

    public function index(Request $request)
    {
        $data = $this->buildDepartmentsIndexData($request);

        if ($response = $this->ajaxTableResponse(
            $request,
            $data,
            'admin.academic.departments.partials.list',
            'admin.academic.departments.partials.modals'
        )) {
            return $response;
        }

        return view('admin.academic.departments.index', $data);
    }

    /**
     * @return array{departments: \Illuminate\Contracts\Pagination\LengthAwarePaginator, colleges: \Illuminate\Support\Collection, stats: array<string, int>}
     */
    private function buildDepartmentsIndexData(Request $request): array
    {
        $query = Department::with('college')->withCount('programs');

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

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $departments = $query->orderBy('sort_order')->orderBy('name')->paginate(20)->withQueryString();
        $colleges = College::ordered()->get();

        $stats = [
            'total' => Department::count(),
            'active' => Department::where('is_active', true)->count(),
            'inactive' => Department::where('is_active', false)->count(),
            'filtered' => $departments->total(),
        ];

        return compact('departments', 'colleges', 'stats');
    }

    public function create(Request $request)
    {
        $colleges = College::ordered()->get();
        $selectedCollegeId = $request->get('college_id');

        return view('admin.academic.departments.create', compact('colleges', 'selectedCollegeId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'college_id.required' => 'الكلية مطلوبة.',
            'college_id.exists' => 'الكلية المحددة غير موجودة.',
            'name.required' => 'اسم القسم مطلوب.',
            'name.max' => 'اسم القسم يجب ألا يتجاوز 255 حرفاً.',
        ]);

        if (Department::where('college_id', $validated['college_id'])->where('name', $validated['name'])->exists()) {
            return back()->withInput()->with('error', 'اسم القسم موجود مسبقاً في هذه الكلية.');
        }

        $validated['slug'] = $this->generateUniqueSlug(
            $validated['name'],
            Department::class,
            null,
            ['college_id' => $validated['college_id']]
        );
        $validated['is_active'] = $this->resolveIsActive($request);
        $validated['sort_order'] = $validated['sort_order'] ?? ((Department::where('college_id', $validated['college_id'])->max('sort_order') ?? 0) + 1);

        Department::create($validated);

        return redirect()->route('admin.academic.departments.index', ['college_id' => $validated['college_id']])
            ->with('success', 'تم إنشاء القسم بنجاح');
    }

    public function show(Department $department)
    {
        $department->load([
            'college',
            'programs' => fn ($q) => $q->ordered(),
        ]);
        $department->loadCount('staffMembers');
        $staffCount = $department->staff_members_count;

        return view('admin.academic.departments.show', compact('department', 'staffCount'));
    }

    public function edit(Department $department)
    {
        $department->load('college')->loadCount(['programs', 'staffMembers']);
        $colleges = College::ordered()->get();

        return view('admin.academic.departments.edit', compact('department', 'colleges'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'college_id' => 'required|exists:colleges,id',
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'college_id.required' => 'الكلية مطلوبة.',
            'college_id.exists' => 'الكلية المحددة غير موجودة.',
            'name.required' => 'اسم القسم مطلوب.',
            'name.max' => 'اسم القسم يجب ألا يتجاوز 255 حرفاً.',
        ]);

        if (Department::where('college_id', $validated['college_id'])
            ->where('name', $validated['name'])
            ->where('id', '!=', $department->id)
            ->exists()) {
            return back()->withInput()->with('error', 'اسم القسم موجود مسبقاً في هذه الكلية.');
        }

        $validated['is_active'] = $this->resolveIsActive($request);

        if ($validated['name'] !== $department->name || $validated['college_id'] != $department->college_id) {
            $validated['slug'] = $this->generateUniqueSlug(
                $validated['name'],
                Department::class,
                $department->id,
                ['college_id' => $validated['college_id']]
            );
        }

        $department->update($validated);

        return redirect()->route('admin.academic.departments.index', ['college_id' => $validated['college_id']])
            ->with('success', 'تم تحديث القسم بنجاح');
    }

    public function destroy(Department $department)
    {
        if ($department->programs()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف القسم لأنه يحتوي على برامج.');
        }

        $department->delete();

        return redirect()->route('admin.academic.departments.index')
            ->with('success', 'تم حذف القسم بنجاح');
    }

    public function toggleActive(Department $department)
    {
        $department->update(['is_active' => ! $department->is_active]);

        return back()->with('success', 'تم تحديث حالة القسم');
    }
}
