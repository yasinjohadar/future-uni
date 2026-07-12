<?php

namespace App\Http\Controllers\Admin\Academic;

use App\Http\Controllers\Admin\Concerns\GeneratesArabicSlug;
use App\Http\Controllers\Controller;
use App\Models\AcademicTerm;
use Illuminate\Http\Request;

class AcademicTermController extends Controller
{
    use GeneratesArabicSlug;

    public function index(Request $request)
    {
        $query = AcademicTerm::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $filteredCount = (clone $query)->count();
        $terms = $query->orderByDesc('starts_at')->orderBy('name')->paginate(20)->withQueryString();

        $stats = [
            'total' => AcademicTerm::count(),
            'active' => AcademicTerm::where('is_active', true)->count(),
            'current' => AcademicTerm::where('is_current', true)->count(),
            'filtered' => $filteredCount,
        ];

        return view('admin.academic.terms.index', compact('terms', 'stats'));
    }

    public function create()
    {
        return view('admin.academic.terms.create');
    }

    public function show(AcademicTerm $term)
    {
        return redirect()->route('admin.academic.terms.edit', $term);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:academic_terms,code',
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'registration_opens_at' => 'nullable|date',
            'registration_closes_at' => 'nullable|date|after_or_equal:registration_opens_at',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'اسم الفصل مطلوب.',
            'code.required' => 'رمز الفصل مطلوب.',
            'code.unique' => 'رمز الفصل موجود مسبقاً.',
        ]);

        $validated['is_active'] = $this->resolveIsActive($request);
        $validated['is_current'] = false;

        AcademicTerm::create($validated);

        return redirect()->route('admin.academic.terms.index')
            ->with('success', 'تم إنشاء الفصل الدراسي بنجاح');
    }

    public function edit(AcademicTerm $term)
    {
        return view('admin.academic.terms.edit', compact('term'));
    }

    public function update(Request $request, AcademicTerm $term)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:academic_terms,code,' . $term->id,
            'starts_at' => 'nullable|date',
            'ends_at' => 'nullable|date|after_or_equal:starts_at',
            'registration_opens_at' => 'nullable|date',
            'registration_closes_at' => 'nullable|date|after_or_equal:registration_opens_at',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'اسم الفصل مطلوب.',
            'code.required' => 'رمز الفصل مطلوب.',
            'code.unique' => 'رمز الفصل موجود مسبقاً.',
        ]);

        $validated['is_active'] = $this->resolveIsActive($request);

        $term->update($validated);

        return redirect()->route('admin.academic.terms.index')
            ->with('success', 'تم تحديث الفصل الدراسي بنجاح');
    }

    public function destroy(AcademicTerm $term)
    {
        if ($term->sections()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف الفصل لأنه مرتبط بشعب دراسية.');
        }

        $term->delete();

        return redirect()->route('admin.academic.terms.index')
            ->with('success', 'تم حذف الفصل الدراسي بنجاح');
    }

    public function markCurrent(AcademicTerm $term)
    {
        $term->markAsCurrent();

        return back()->with('success', 'تم تعيين الفصل كفصل حالي');
    }
}
