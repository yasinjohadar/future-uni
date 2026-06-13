<?php

namespace App\Http\Controllers\Admin\Library;

use App\Http\Controllers\Admin\Concerns\GeneratesArabicSlug;
use App\Http\Controllers\Concerns\RespondsWithAjaxTable;
use App\Http\Controllers\Controller;
use App\Models\LibraryCategory;
use Illuminate\Http\Request;

class LibraryCategoryController extends Controller
{
    use GeneratesArabicSlug;
    use RespondsWithAjaxTable;

    public function index(Request $request)
    {
        $data = $this->buildIndexData($request);

        if ($response = $this->ajaxTableResponse(
            $request,
            $data,
            'admin.library.categories.partials.list',
            'admin.library.categories.partials.modals'
        )) {
            return $response;
        }

        return view('admin.library.categories.index', $data);
    }

    private function buildIndexData(Request $request): array
    {
        $query = LibraryCategory::withCount('books');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $filteredCount = (clone $query)->count();
        $categories = $query->ordered()->paginate(20)->withQueryString();

        return [
            'categories' => $categories,
            'stats' => [
                'total' => LibraryCategory::count(),
                'active' => LibraryCategory::where('is_active', true)->count(),
                'inactive' => LibraryCategory::where('is_active', false)->count(),
                'books' => \App\Models\LibraryBook::count(),
                'filtered' => $filteredCount,
            ],
        ];
    }

    public function create()
    {
        return view('admin.library.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateCategory($request);
        $validated['slug'] = $this->resolveSlug($request, $validated['name']);
        $validated['is_active'] = $this->resolveIsActive($request);
        $validated['sort_order'] = $validated['sort_order'] ?? ((LibraryCategory::max('sort_order') ?? 0) + 1);

        LibraryCategory::create($validated);

        return redirect()->route('admin.library.categories.index')
            ->with('success', 'تم إنشاء التصنيف بنجاح');
    }

    public function edit(LibraryCategory $library_category)
    {
        return view('admin.library.categories.edit', ['category' => $library_category]);
    }

    public function update(Request $request, LibraryCategory $library_category)
    {
        $validated = $this->validateCategory($request, $library_category->id);
        $validated['is_active'] = $this->resolveIsActive($request);

        if ($request->filled('slug')) {
            $validated['slug'] = $request->slug;
        } elseif ($validated['name'] !== $library_category->name) {
            $validated['slug'] = $this->generateUniqueSlug($validated['name'], LibraryCategory::class, $library_category->id);
        }

        $library_category->update($validated);

        return redirect()->route('admin.library.categories.index')
            ->with('success', 'تم تحديث التصنيف بنجاح');
    }

    public function destroy(LibraryCategory $library_category)
    {
        if ($library_category->books()->exists()) {
            return back()->with('error', 'لا يمكن حذف تصنيف مرتبط بكتب.');
        }

        $library_category->delete();

        return redirect()->route('admin.library.categories.index')
            ->with('success', 'تم حذف التصنيف بنجاح');
    }

    public function toggleActive(LibraryCategory $library_category)
    {
        $library_category->update(['is_active' => ! $library_category->is_active]);

        return back()->with('success', 'تم تحديث حالة التصنيف');
    }

    private function validateCategory(Request $request, ?int $ignoreId = null): array
    {
        $uniqueName = 'unique:library_categories,name';
        if ($ignoreId) {
            $uniqueName .= ',' . $ignoreId;
        }

        return $request->validate([
            'name' => 'required|string|max:255|' . $uniqueName,
            'slug' => 'nullable|string|max:255',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:20',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'اسم التصنيف مطلوب.',
            'name.unique' => 'اسم التصنيف موجود مسبقاً.',
        ]);
    }

    private function resolveSlug(Request $request, string $name): string
    {
        if ($request->filled('slug')) {
            return $request->slug;
        }

        return $this->generateUniqueSlug($name, LibraryCategory::class);
    }
}
