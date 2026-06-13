<?php

namespace App\Http\Controllers\Admin\Research;

use App\Http\Controllers\Admin\Concerns\GeneratesArabicSlug;
use App\Http\Controllers\Concerns\RespondsWithAjaxTable;
use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\ResearchCenter;
use App\Models\StaffMember;
use Illuminate\Http\Request;

class ResearchCenterController extends Controller
{
    use GeneratesArabicSlug;
    use RespondsWithAjaxTable;

    public function index(Request $request)
    {
        $data = $this->buildIndexData($request);

        if ($response = $this->ajaxTableResponse(
            $request,
            $data,
            'admin.research.centers.partials.list',
            'admin.research.centers.partials.modals'
        )) {
            return $response;
        }

        return view('admin.research.centers.index', $data);
    }

    private function buildIndexData(Request $request): array
    {
        $query = ResearchCenter::with(['college', 'director']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhere('director_title', 'like', "%{$search}%");
            });
        }

        if ($request->filled('college_id')) {
            $query->where('college_id', $request->college_id);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $filteredCount = (clone $query)->count();
        $centers = $query->orderBy('sort_order')->orderBy('name')->paginate(20)->withQueryString();

        return [
            'centers' => $centers,
            'colleges' => College::ordered()->get(),
            'stats' => [
                'total' => ResearchCenter::count(),
                'active' => ResearchCenter::where('is_active', true)->count(),
                'inactive' => ResearchCenter::where('is_active', false)->count(),
                'projects' => ResearchCenter::sum('projects_count'),
                'filtered' => $filteredCount,
            ],
        ];
    }

    public function create()
    {
        return view('admin.research.centers.create', [
            'colleges' => College::ordered()->get(),
            'staffMembers' => StaffMember::active()->ordered()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $request->merge([
            'college_id' => $request->input('college_id') ?: null,
            'director_id' => $request->input('director_id') ?: null,
        ]);

        $validated = $this->validateCenter($request);
        $validated['slug'] = $this->generateUniqueSlug($validated['name'], ResearchCenter::class);
        $validated['is_active'] = $this->resolveIsActive($request);
        $validated['sort_order'] = $validated['sort_order'] ?? ((ResearchCenter::max('sort_order') ?? 0) + 1);
        $validated = array_merge($validated, $this->parseStructuredFields($request));

        ResearchCenter::create($validated);

        return redirect()->route('admin.research.centers.index')
            ->with('success', 'تم إنشاء مركز البحث بنجاح');
    }

    public function show(ResearchCenter $research_center)
    {
        $research_center->load(['college', 'director']);

        return view('admin.research.centers.show', ['center' => $research_center]);
    }

    public function edit(ResearchCenter $research_center)
    {
        return view('admin.research.centers.edit', [
            'center' => $research_center,
            'colleges' => College::ordered()->get(),
            'staffMembers' => StaffMember::active()->ordered()->get(),
        ]);
    }

    public function update(Request $request, ResearchCenter $research_center)
    {
        $request->merge([
            'college_id' => $request->input('college_id') ?: null,
            'director_id' => $request->input('director_id') ?: null,
        ]);

        $validated = $this->validateCenter($request, $research_center->id);
        $validated['is_active'] = $this->resolveIsActive($request);

        if ($validated['name'] !== $research_center->name) {
            $validated['slug'] = $this->generateUniqueSlug($validated['name'], ResearchCenter::class, $research_center->id);
        }

        $research_center->update(array_merge($validated, $this->parseStructuredFields($request)));

        return redirect()->route('admin.research.centers.index')
            ->with('success', 'تم تحديث مركز البحث بنجاح');
    }

    public function destroy(ResearchCenter $research_center)
    {
        $research_center->delete();

        return redirect()->route('admin.research.centers.index')
            ->with('success', 'تم حذف مركز البحث بنجاح');
    }

    public function toggleActive(ResearchCenter $research_center)
    {
        $research_center->update(['is_active' => ! $research_center->is_active]);

        return back()->with('success', 'تم تحديث حالة مركز البحث');
    }

    private function validateCenter(Request $request, ?int $ignoreId = null): array
    {
        $uniqueName = 'unique:research_centers,name';
        if ($ignoreId) {
            $uniqueName .= ',' . $ignoreId;
        }

        return $request->validate([
            'name' => 'required|string|max:255|' . $uniqueName,
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'long_description' => 'nullable|string',
            'college_id' => 'nullable|exists:colleges,id',
            'director_id' => 'nullable|exists:staff_members,id',
            'director_title' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'established' => 'nullable|string|max:20',
            'projects_count' => 'nullable|integer|min:0',
            'publications_count' => 'nullable|integer|min:0',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'اسم المركز مطلوب.',
            'name.unique' => 'اسم المركز موجود مسبقاً.',
        ]);
    }

    private function parseStructuredFields(Request $request): array
    {
        $focusAreas = collect(preg_split('/\r\n|\r|\n/', (string) $request->input('focus_areas_text', '')))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        $partners = collect(preg_split('/\r\n|\r|\n/', (string) $request->input('partners_text', '')))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        $activeProjects = [];
        foreach (preg_split('/\r\n|\r|\n/', (string) $request->input('active_projects_text', '')) as $line) {
            $line = trim($line);
            if ($line === '') {
                continue;
            }
            $parts = array_map('trim', explode('|', $line, 2));
            $activeProjects[] = [
                'title' => $parts[0] ?? '',
                'status' => $parts[1] ?? 'جاري',
            ];
        }

        return [
            'focus_areas' => $focusAreas,
            'partners' => $partners,
            'active_projects' => $activeProjects,
            'stats' => [
                'researchers' => (int) $request->input('stats_researchers', 0),
                'labs' => (int) $request->input('stats_labs', 0),
                'grants' => (int) $request->input('stats_grants', 0),
            ],
        ];
    }
}
