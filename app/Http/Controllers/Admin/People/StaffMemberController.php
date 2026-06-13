<?php

namespace App\Http\Controllers\Admin\People;

use App\Enums\StaffType;
use App\Http\Controllers\Admin\Concerns\GeneratesArabicSlug;
use App\Http\Controllers\Concerns\RespondsWithAjaxTable;
use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Department;
use App\Models\Program;
use App\Models\StaffMember;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StaffMemberController extends Controller
{
    use GeneratesArabicSlug;
    use RespondsWithAjaxTable;

    public function index(Request $request)
    {
        $data = $this->buildStaffIndexData($request);

        if ($response = $this->ajaxTableResponse(
            $request,
            $data,
            'admin.people.staff.partials.list',
            'admin.people.staff.partials.modals'
        )) {
            return $response;
        }

        return view('admin.people.staff.index', $data);
    }

    /**
     * @return array{staffMembers: \Illuminate\Contracts\Pagination\LengthAwarePaginator, colleges: \Illuminate\Support\Collection, types: array<int, StaffType>, stats: array<string, int>}
     */
    private function buildStaffIndexData(Request $request): array
    {
        $query = StaffMember::with(['college', 'department']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('position', 'like', "%{$search}%")
                    ->orWhere('specialty', 'like', "%{$search}%");
            });
        }

        if ($request->filled('type')) {
            $query->ofType($request->type);
        }

        if ($request->filled('college_id')) {
            $query->where('college_id', $request->college_id);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $staffMembers = $query->orderBy('sort_order')->orderBy('name')->paginate(20)->withQueryString();
        $colleges = College::ordered()->get();
        $types = StaffType::cases();

        $stats = [
            'total' => StaffMember::count(),
            'active' => StaffMember::where('is_active', true)->count(),
            'featured' => StaffMember::where('is_featured', true)->count(),
            'filtered' => $staffMembers->total(),
        ];

        return compact('staffMembers', 'colleges', 'types', 'stats');
    }

    public function create()
    {
        $colleges = College::ordered()->get();
        $departments = Department::ordered()->get();
        $programs = Program::ordered()->get();
        $types = StaffType::cases();

        return view('admin.people.staff.create', compact('colleges', 'departments', 'programs', 'types'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'type' => ['required', Rule::enum(StaffType::class)],
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'academic_title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'office' => 'nullable|string|max:255',
            'stats' => 'nullable|array',
            'stats.publications' => 'nullable|integer|min:0',
            'stats.citations' => 'nullable|integer|min:0',
            'stats.hIndex' => 'nullable|integer|min:0',
            'stats.experience' => 'nullable|integer|min:0',
            'icon' => 'nullable|string|max:100',
            'college_id' => 'nullable|exists:colleges,id',
            'department_id' => 'nullable|exists:departments,id',
            'program_id' => 'nullable|exists:programs,id',
            'sort_order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ], [
            'type.required' => 'نوع العضو مطلوب.',
            'name.required' => 'الاسم مطلوب.',
            'name.max' => 'الاسم يجب ألا يتجاوز 255 حرفاً.',
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['name'], StaffMember::class);
        $validated['is_active'] = $this->resolveIsActive($request);
        $validated['is_featured'] = $this->resolveIsActive($request, 'is_featured');
        $validated['sort_order'] = $validated['sort_order'] ?? ((StaffMember::max('sort_order') ?? 0) + 1);
        $validated['stats'] = $this->normalizeStats($validated['stats'] ?? null);

        StaffMember::create($validated);

        return redirect()->route('admin.people.staff.index')
            ->with('success', 'تم إضافة العضو بنجاح');
    }

    public function show(StaffMember $staff)
    {
        $staff->load(['college', 'department', 'program']);

        return view('admin.people.staff.show', compact('staff'));
    }

    public function edit(StaffMember $staff)
    {
        $staff->load(['college', 'department', 'program']);
        $colleges = College::ordered()->get();
        $departments = Department::ordered()->get();
        $programs = Program::ordered()->get();
        $types = StaffType::cases();

        return view('admin.people.staff.edit', compact('staff', 'colleges', 'departments', 'programs', 'types'));
    }

    public function update(Request $request, StaffMember $staff)
    {
        $validated = $request->validate([
            'type' => ['required', Rule::enum(StaffType::class)],
            'name' => 'required|string|max:255',
            'position' => 'nullable|string|max:255',
            'specialty' => 'nullable|string|max:255',
            'academic_title' => 'nullable|string|max:255',
            'bio' => 'nullable|string',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'office' => 'nullable|string|max:255',
            'stats' => 'nullable|array',
            'stats.publications' => 'nullable|integer|min:0',
            'stats.citations' => 'nullable|integer|min:0',
            'stats.hIndex' => 'nullable|integer|min:0',
            'stats.experience' => 'nullable|integer|min:0',
            'icon' => 'nullable|string|max:100',
            'college_id' => 'nullable|exists:colleges,id',
            'department_id' => 'nullable|exists:departments,id',
            'program_id' => 'nullable|exists:programs,id',
            'sort_order' => 'nullable|integer|min:0',
            'is_featured' => 'boolean',
            'is_active' => 'boolean',
        ], [
            'type.required' => 'نوع العضو مطلوب.',
            'name.required' => 'الاسم مطلوب.',
            'name.max' => 'الاسم يجب ألا يتجاوز 255 حرفاً.',
        ]);

        $validated['is_active'] = $this->resolveIsActive($request);
        $validated['is_featured'] = $this->resolveIsActive($request, 'is_featured');

        if ($validated['name'] !== $staff->name) {
            $validated['slug'] = $this->generateUniqueSlug($validated['name'], StaffMember::class, $staff->id);
        }

        $validated['stats'] = $this->normalizeStats($validated['stats'] ?? null);

        $staff->update($validated);

        return redirect()->route('admin.people.staff.index')
            ->with('success', 'تم تحديث بيانات العضو بنجاح');
    }

    public function destroy(StaffMember $staff)
    {
        $staff->delete();

        return redirect()->route('admin.people.staff.index')
            ->with('success', 'تم حذف العضو بنجاح');
    }

    public function toggleActive(StaffMember $staff)
    {
        $staff->update(['is_active' => ! $staff->is_active]);

        return back()->with('success', 'تم تحديث حالة العضو');
    }

    private function normalizeStats(?array $stats): ?array
    {
        if ($stats === null) {
            return null;
        }

        $filtered = array_filter($stats, fn ($value) => $value !== null && $value !== '');

        return $filtered === [] ? null : $filtered;
    }
}
