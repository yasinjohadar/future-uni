<?php

namespace App\Http\Controllers\Admin\Admission;

use App\Http\Controllers\Controller;
use App\Models\AdmissionApplication;
use App\Models\AdmissionCycle;
use Illuminate\Http\Request;

class AdmissionCycleController extends Controller
{
    public function index(Request $request)
    {
        $query = AdmissionCycle::withCount('applications');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('academic_year', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_open', $request->status === 'open');
        }

        $filteredCount = (clone $query)->count();
        $cycles = $query->orderByDesc('start_date')->orderByDesc('id')->paginate(20)->withQueryString();

        $stats = [
            'total' => AdmissionCycle::count(),
            'open' => AdmissionCycle::where('is_open', true)->count(),
            'applications' => AdmissionApplication::count(),
            'filtered' => $filteredCount,
        ];

        return view('admin.admission.cycles.index', compact('cycles', 'stats'));
    }

    public function create()
    {
        return view('admin.admission.cycles.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'academic_year' => 'required|string|max:50',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'is_open' => 'boolean',
        ], [
            'name.required' => 'اسم الدورة مطلوب.',
            'academic_year.required' => 'السنة الأكاديمية مطلوبة.',
            'end_date.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البداية.',
        ]);

        $validated['is_open'] = $request->has('is_open') && $request->is_open == '1' ? 1 : 0;

        AdmissionCycle::create($validated);

        return redirect()->route('admin.admission.cycles.index')
            ->with('success', 'تم إنشاء دورة القبول بنجاح');
    }

    public function show(AdmissionCycle $cycle)
    {
        $cycle->loadCount('applications');
        $cycle->load(['applications' => fn ($q) => $q->latest()->limit(10)]);

        return view('admin.admission.cycles.show', compact('cycle'));
    }

    public function edit(AdmissionCycle $cycle)
    {
        return view('admin.admission.cycles.edit', compact('cycle'));
    }

    public function update(Request $request, AdmissionCycle $cycle)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'academic_year' => 'required|string|max:50',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'description' => 'nullable|string',
            'is_open' => 'boolean',
        ], [
            'name.required' => 'اسم الدورة مطلوب.',
            'academic_year.required' => 'السنة الأكاديمية مطلوبة.',
            'end_date.after_or_equal' => 'تاريخ الانتهاء يجب أن يكون بعد تاريخ البداية.',
        ]);

        $validated['is_open'] = $request->has('is_open') && $request->is_open == '1' ? 1 : 0;

        $cycle->update($validated);

        return redirect()->route('admin.admission.cycles.index')
            ->with('success', 'تم تحديث دورة القبول بنجاح');
    }

    public function destroy(AdmissionCycle $cycle)
    {
        if ($cycle->applications()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف الدورة لأنها مرتبطة بطلبات قبول.');
        }

        $cycle->delete();

        return redirect()->route('admin.admission.cycles.index')
            ->with('success', 'تم حذف دورة القبول بنجاح');
    }

    public function toggleActive(AdmissionCycle $cycle)
    {
        $cycle->update(['is_open' => ! $cycle->is_open]);

        return back()->with('success', 'تم تحديث حالة الدورة');
    }
}
