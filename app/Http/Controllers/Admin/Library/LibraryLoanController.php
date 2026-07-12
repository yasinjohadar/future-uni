<?php

namespace App\Http\Controllers\Admin\Library;

use App\Enums\LibraryLoanStatus;
use App\Http\Controllers\Controller;
use App\Models\LibraryBook;
use App\Models\LibraryLoan;
use App\Models\Student;
use Illuminate\Http\Request;

class LibraryLoanController extends Controller
{
    public function index(Request $request)
    {
        $query = LibraryLoan::with(['student.user', 'book']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('student', fn ($s) => $s->where('student_number', 'like', "%{$search}%")
                    ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")))
                    ->orWhereHas('book', fn ($b) => $b->where('title', 'like', "%{$search}%"));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $filteredCount = (clone $query)->count();
        $loans = $query->latest('borrowed_at')->paginate(20)->withQueryString();
        $statuses = LibraryLoanStatus::cases();

        $stats = [
            'total' => LibraryLoan::count(),
            'active' => LibraryLoan::whereIn('status', [LibraryLoanStatus::Borrowed, LibraryLoanStatus::Overdue])->count(),
            'filtered' => $filteredCount,
        ];

        return view('admin.library.loans.index', compact('loans', 'statuses', 'stats'));
    }

    public function create(Request $request)
    {
        $students = Student::with('user')->latest()->limit(200)->get();
        $books = LibraryBook::active()->ordered()->where('copies_available', '>', 0)->get();
        $selectedStudentId = $request->get('student_id');
        $selectedBookId = $request->get('library_book_id');

        return view('admin.library.loans.create', compact('students', 'books', 'selectedStudentId', 'selectedBookId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'library_book_id' => 'required|exists:library_books,id',
            'borrowed_at' => 'nullable|date',
            'due_at' => 'nullable|date|after_or_equal:borrowed_at',
            'notes' => 'nullable|string',
        ], [
            'student_id.required' => 'الطالب مطلوب.',
            'library_book_id.required' => 'الكتاب مطلوب.',
        ]);

        $book = LibraryBook::findOrFail($validated['library_book_id']);

        if ($book->copies_available <= 0) {
            return back()->withInput()->with('error', 'لا توجد نسخ متاحة من هذا الكتاب.');
        }

        LibraryLoan::create([
            'student_id' => $validated['student_id'],
            'library_book_id' => $validated['library_book_id'],
            'borrowed_at' => $validated['borrowed_at'] ?? now(),
            'due_at' => $validated['due_at'] ?? null,
            'status' => LibraryLoanStatus::Borrowed,
            'notes' => $validated['notes'] ?? null,
        ]);

        $book->decrement('copies_available');
        $book->syncAvailability();
        $book->save();

        return redirect()->route('admin.library.loans.index')
            ->with('success', 'تم تسجيل الاستعارة بنجاح');
    }

    public function returnBook(LibraryLoan $loan)
    {
        if ($loan->status === LibraryLoanStatus::Returned) {
            return back()->with('error', 'تم إرجاع هذا الكتاب مسبقاً.');
        }

        $loan->returned_at = now();
        $loan->status = LibraryLoanStatus::Returned;
        $loan->save();

        $book = $loan->book;
        if ($book) {
            $book->increment('copies_available');
            $book->syncAvailability();
            $book->save();
        }

        return back()->with('success', 'تم إرجاع الكتاب بنجاح');
    }
}
