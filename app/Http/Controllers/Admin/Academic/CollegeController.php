<?php

namespace App\Http\Controllers\Admin\Academic;

use App\Http\Controllers\Admin\Concerns\GeneratesArabicSlug;
use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Department;
use Illuminate\Http\Request;

class CollegeController extends Controller
{
    use GeneratesArabicSlug;

    public function index(Request $request)
    {
        $query = College::withCount(['departments', 'programs']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $filteredCount = (clone $query)->count();
        $colleges = $query->orderBy('sort_order')->orderBy('name')->paginate(20)->withQueryString();

        $stats = [
            'total' => College::count(),
            'active' => College::where('is_active', true)->count(),
            'inactive' => College::where('is_active', false)->count(),
            'departments' => Department::count(),
            'filtered' => $filteredCount,
        ];

        return view('admin.academic.colleges.index', compact('colleges', 'stats'));
    }

    public function create()
    {
        return view('admin.academic.colleges.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colleges,name',
            'category' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'established' => 'nullable|string|max:50',
            'students_count' => 'nullable|string|max:50',
            'building' => 'nullable|string|max:255',
            'accreditation' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'اسم الكلية مطلوب.',
            'name.unique' => 'اسم الكلية موجود مسبقاً.',
            'name.max' => 'اسم الكلية يجب ألا يتجاوز 255 حرفاً.',
        ]);

        $validated['slug'] = $this->generateUniqueSlug($validated['name'], College::class);
        $validated['is_active'] = $this->resolveIsActive($request);
        $validated['sort_order'] = $validated['sort_order'] ?? ((College::max('sort_order') ?? 0) + 1);

        College::create($validated);

        return redirect()->route('admin.academic.colleges.index')
            ->with('success', 'تم إنشاء الكلية بنجاح');
    }

    public function show(College $college)
    {
        $college->loadCount(['departments', 'programs', 'staffMembers']);
        $college->load([
            'dean',
            'departments' => fn ($q) => $q->ordered()->limit(12),
            'programs' => fn ($q) => $q->ordered()->limit(8),
        ]);

        return view('admin.academic.colleges.show', compact('college'));
    }

    public function edit(College $college)
    {
        $college->loadCount(['departments', 'programs', 'staffMembers']);

        return view('admin.academic.colleges.edit', compact('college'));
    }

    public function update(Request $request, College $college)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:colleges,name,' . $college->id,
            'category' => 'nullable|string|max:100',
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'established' => 'nullable|string|max:50',
            'students_count' => 'nullable|string|max:50',
            'building' => 'nullable|string|max:255',
            'accreditation' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'اسم الكلية مطلوب.',
            'name.unique' => 'اسم الكلية موجود مسبقاً.',
            'name.max' => 'اسم الكلية يجب ألا يتجاوز 255 حرفاً.',
        ]);

        $validated['is_active'] = $this->resolveIsActive($request);

        if ($validated['name'] !== $college->name) {
            $validated['slug'] = $this->generateUniqueSlug($validated['name'], College::class, $college->id);
        }

        $college->update($validated);

        return redirect()->route('admin.academic.colleges.index')
            ->with('success', 'تم تحديث الكلية بنجاح');
    }

    public function destroy(College $college)
    {
        if ($college->departments()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف الكلية لأنها تحتوي على أقسام.');
        }

        $college->delete();

        return redirect()->route('admin.academic.colleges.index')
            ->with('success', 'تم حذف الكلية بنجاح');
    }

    public function toggleActive(College $college)
    {
        $college->update(['is_active' => ! $college->is_active]);

        return back()->with('success', 'تم تحديث حالة الكلية');
    }
}
