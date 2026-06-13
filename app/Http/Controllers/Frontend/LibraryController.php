<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\LibraryBook;
use App\Models\LibraryCategory;
use App\Models\LibrarySetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LibraryController extends Controller
{
    public function index(Request $request): View
    {
        $categories = LibraryCategory::active()->ordered()->get();
        $settings = LibrarySetting::instance();

        $activeCategory = $request->string('category')->toString() ?: 'all';
        $searchQuery = $request->string('q')->toString();

        $books = $this->buildBooksQuery($activeCategory, $searchQuery)
            ->with('category')
            ->ordered()
            ->get();

        $highlights = [
            'books' => LibraryBook::active()->count(),
            'categories' => $categories->count(),
            'digital_references' => $settings->digital_references,
            'reading_seats' => $settings->reading_seats,
        ];

        return view('frontend.pages.library', compact(
            'categories',
            'books',
            'highlights',
            'activeCategory',
            'searchQuery'
        ));
    }

    public function search(Request $request): JsonResponse
    {
        $activeCategory = $request->string('category')->toString() ?: 'all';
        $searchQuery = $request->string('q')->toString();

        $books = $this->buildBooksQuery($activeCategory, $searchQuery)
            ->with('category')
            ->ordered()
            ->get();

        $html = view('frontend.pages.partials.library.books-grid', compact('books'))->render();

        return response()->json([
            'success' => true,
            'html' => $html,
            'count' => $books->count(),
        ]);
    }

    public function show(string $slug): View
    {
        $book = LibraryBook::where('slug', $slug)
            ->where('is_active', true)
            ->with('category')
            ->firstOrFail();

        $relatedBooks = LibraryBook::active()
            ->where('id', '!=', $book->id)
            ->where('library_category_id', $book->library_category_id)
            ->ordered()
            ->limit(4)
            ->get();

        return view('frontend.pages.book-detail', compact('book', 'relatedBooks'));
    }

    public function legacyDetail(Request $request): RedirectResponse
    {
        if ($request->filled('id')) {
            $book = LibraryBook::find($request->integer('id'));
            if ($book) {
                return redirect()->route('library.book.show', $book->slug, 301);
            }
        }

        return redirect()->route('library');
    }

    private function buildBooksQuery(string $categorySlug, ?string $search)
    {
        return LibraryBook::active()
            ->inCategory($categorySlug)
            ->search($search);
    }
}
