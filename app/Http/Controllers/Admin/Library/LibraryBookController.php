<?php

namespace App\Http\Controllers\Admin\Library;

use App\Http\Controllers\Admin\Concerns\GeneratesArabicSlug;
use App\Http\Controllers\Concerns\RespondsWithAjaxTable;
use App\Http\Controllers\Controller;
use App\Models\LibraryBook;
use App\Models\LibraryCategory;
use Illuminate\Http\Request;

class LibraryBookController extends Controller
{
    use GeneratesArabicSlug;
    use RespondsWithAjaxTable;

    public function index(Request $request)
    {
        $data = $this->buildIndexData($request);

        if ($response = $this->ajaxTableResponse(
            $request,
            $data,
            'admin.library.books.partials.list',
            'admin.library.books.partials.modals'
        )) {
            return $response;
        }

        return view('admin.library.books.index', $data);
    }

    private function buildIndexData(Request $request): array
    {
        $query = LibraryBook::with('category');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->search($search);
        }

        if ($request->filled('library_category_id')) {
            $query->where('library_category_id', $request->library_category_id);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'active');
        }

        $filteredCount = (clone $query)->count();
        $books = $query->ordered()->paginate(20)->withQueryString();

        return [
            'books' => $books,
            'categories' => LibraryCategory::ordered()->get(),
            'stats' => [
                'total' => LibraryBook::count(),
                'active' => LibraryBook::where('is_active', true)->count(),
                'inactive' => LibraryBook::where('is_active', false)->count(),
                'available' => LibraryBook::where('is_available', true)->count(),
                'filtered' => $filteredCount,
            ],
        ];
    }

    public function create()
    {
        return view('admin.library.books.create', [
            'categories' => LibraryCategory::ordered()->get(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateBook($request);
        $validated['slug'] = $this->generateUniqueSlug($validated['title'], LibraryBook::class);
        $validated['is_active'] = $this->resolveIsActive($request);
        $validated['sort_order'] = $validated['sort_order'] ?? ((LibraryBook::max('sort_order') ?? 0) + 1);
        $validated = array_merge($validated, $this->parseStructuredFields($request));
        $validated['is_available'] = ($validated['copies_available'] ?? 0) > 0;

        LibraryBook::create($validated);

        return redirect()->route('admin.library.books.index')
            ->with('success', 'تم إنشاء الكتاب بنجاح');
    }

    public function show(LibraryBook $library_book)
    {
        $library_book->load('category');

        return view('admin.library.books.show', ['book' => $library_book]);
    }

    public function edit(LibraryBook $library_book)
    {
        return view('admin.library.books.edit', [
            'book' => $library_book,
            'categories' => LibraryCategory::ordered()->get(),
        ]);
    }

    public function update(Request $request, LibraryBook $library_book)
    {
        $validated = $this->validateBook($request, $library_book->id);
        $validated['is_active'] = $this->resolveIsActive($request);

        if ($validated['title'] !== $library_book->title) {
            $validated['slug'] = $this->generateUniqueSlug($validated['title'], LibraryBook::class, $library_book->id);
        }

        $validated = array_merge($validated, $this->parseStructuredFields($request));
        $validated['is_available'] = ($validated['copies_available'] ?? 0) > 0;

        $library_book->update($validated);

        return redirect()->route('admin.library.books.index')
            ->with('success', 'تم تحديث الكتاب بنجاح');
    }

    public function destroy(LibraryBook $library_book)
    {
        $library_book->delete();

        return redirect()->route('admin.library.books.index')
            ->with('success', 'تم حذف الكتاب بنجاح');
    }

    public function toggleActive(LibraryBook $library_book)
    {
        $library_book->update(['is_active' => ! $library_book->is_active]);

        return back()->with('success', 'تم تحديث حالة الكتاب');
    }

    private function validateBook(Request $request, ?int $ignoreId = null): array
    {
        return $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'library_category_id' => 'required|exists:library_categories,id',
            'icon' => 'nullable|string|max:100',
            'color' => 'nullable|string|max:20',
            'isbn' => 'nullable|string|max:50',
            'publisher' => 'nullable|string|max:255',
            'edition' => 'nullable|string|max:255',
            'publication_year' => 'nullable|string|max:4',
            'pages' => 'nullable|integer|min:0',
            'language' => 'nullable|string|max:50',
            'rating' => 'nullable|numeric|min:0|max:5',
            'copies_total' => 'nullable|integer|min:0',
            'copies_available' => 'nullable|integer|min:0',
            'shelf_location' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'title.required' => 'عنوان الكتاب مطلوب.',
            'author.required' => 'اسم المؤلف مطلوب.',
            'library_category_id.required' => 'التصنيف مطلوب.',
        ]);
    }

    private function parseStructuredFields(Request $request): array
    {
        $chapters = collect(preg_split('/\r\n|\r|\n/', (string) $request->input('chapters_text', '')))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        $tags = collect(preg_split('/\r\n|\r|\n|,/', (string) $request->input('tags_text', '')))
            ->map(fn ($line) => trim($line))
            ->filter()
            ->values()
            ->all();

        return [
            'chapters' => $chapters,
            'tags' => $tags,
        ];
    }
}
