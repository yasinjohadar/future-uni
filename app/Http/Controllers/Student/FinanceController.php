<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Concerns\ResolvesStudent;
use App\Models\FeeInvoice;
use Illuminate\View\View;

class FinanceController extends Controller
{
    use ResolvesStudent;

    public function index(): View
    {
        $student = $this->student();

        $invoices = FeeInvoice::query()
            ->where('student_id', $student->id)
            ->orderByDesc('due_date')
            ->orderByDesc('created_at')
            ->get();

        $totalOutstanding = $invoices->sum(fn (FeeInvoice $invoice) => $invoice->remaining());

        return view('student.pages.finance.index', [
            'student' => $student,
            'invoices' => $invoices,
            'totalOutstanding' => $totalOutstanding,
        ]);
    }
}
