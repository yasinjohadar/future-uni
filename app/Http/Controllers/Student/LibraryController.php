<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Concerns\ResolvesStudent;
use App\Models\LibraryLoan;
use Illuminate\View\View;

class LibraryController extends Controller
{
    use ResolvesStudent;

    public function index(): View
    {
        $student = $this->student();

        $loans = LibraryLoan::query()
            ->where('student_id', $student->id)
            ->with('book.category')
            ->orderByDesc('borrowed_at')
            ->get();

        $activeLoans = $loans->filter(fn (LibraryLoan $loan) => $loan->isActive());

        return view('student.pages.library.index', [
            'student' => $student,
            'loans' => $loans,
            'activeLoansCount' => $activeLoans->count(),
        ]);
    }
}
