<?php

namespace App\Http\Controllers\Admin\Academic;

use App\Enums\FeeInvoiceStatus;
use App\Http\Controllers\Controller;
use App\Models\FeeInvoice;
use App\Models\FeePayment;
use App\Models\Student;
use Illuminate\Http\Request;

class FeeInvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = FeeInvoice::with(['student.user', 'student.program']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhereHas('student', fn ($s) => $s->where('student_number', 'like', "%{$search}%")
                        ->orWhereHas('user', fn ($u) => $u->where('name', 'like', "%{$search}%")));
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        $filteredCount = (clone $query)->count();
        $invoices = $query->latest()->paginate(20)->withQueryString();
        $statuses = FeeInvoiceStatus::cases();

        $stats = [
            'total' => FeeInvoice::count(),
            'pending' => FeeInvoice::where('status', FeeInvoiceStatus::Pending)->count(),
            'paid' => FeeInvoice::where('status', FeeInvoiceStatus::Paid)->count(),
            'filtered' => $filteredCount,
        ];

        return view('admin.academic.fees.index', compact('invoices', 'statuses', 'stats'));
    }

    public function create(Request $request)
    {
        $students = Student::with('user')->latest()->limit(200)->get();
        $selectedStudentId = $request->get('student_id');

        return view('admin.academic.fees.create', compact('students', 'selectedStudentId'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0.01',
            'due_date' => 'nullable|date',
            'notes' => 'nullable|string',
        ], [
            'student_id.required' => 'الطالب مطلوب.',
            'title.required' => 'عنوان الفاتورة مطلوب.',
            'amount.required' => 'المبلغ مطلوب.',
        ]);

        $validated['paid_amount'] = 0;
        $validated['status'] = FeeInvoiceStatus::Pending;

        FeeInvoice::create($validated);

        return redirect()->route('admin.academic.fees.index')
            ->with('success', 'تم إنشاء فاتورة الرسوم بنجاح');
    }

    public function show(FeeInvoice $fee)
    {
        $fee->load(['student.user', 'student.program', 'payments.recorder']);

        return view('admin.academic.fees.show', ['invoice' => $fee]);
    }

    public function destroy(FeeInvoice $fee)
    {
        if ($fee->payments()->count() > 0) {
            return back()->with('error', 'لا يمكن حذف الفاتورة لأنها تحتوي على دفعات.');
        }

        $fee->delete();

        return redirect()->route('admin.academic.fees.index')
            ->with('success', 'تم حذف فاتورة الرسوم بنجاح');
    }

    public function recordPayment(Request $request, FeeInvoice $fee)
    {
        $validated = $request->validate([
            'amount' => 'required|numeric|min:0.01',
            'paid_at' => 'nullable|date',
            'method' => 'nullable|string|max:100',
            'note' => 'nullable|string',
        ], [
            'amount.required' => 'مبلغ الدفع مطلوب.',
        ]);

        if ($fee->status === FeeInvoiceStatus::Cancelled) {
            return back()->with('error', 'لا يمكن تسجيل دفعة على فاتورة ملغاة.');
        }

        $remaining = $fee->remaining();
        if ($validated['amount'] > $remaining) {
            return back()->with('error', 'مبلغ الدفع يتجاوز المبلغ المتبقي (' . number_format($remaining, 2) . ').');
        }

        FeePayment::create([
            'fee_invoice_id' => $fee->id,
            'amount' => $validated['amount'],
            'paid_at' => $validated['paid_at'] ?? now(),
            'method' => $validated['method'] ?? null,
            'note' => $validated['note'] ?? null,
            'recorded_by' => auth()->id(),
        ]);

        $fee->paid_amount = (float) $fee->paid_amount + (float) $validated['amount'];
        $fee->syncStatus();
        $fee->save();

        return back()->with('success', 'تم تسجيل الدفعة بنجاح');
    }
}
