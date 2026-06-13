<?php

namespace App\Http\Controllers\Admin\Admission;

use App\Enums\AdmissionApplicationStatus;
use App\Http\Controllers\Controller;
use App\Models\AdmissionApplication;
use App\Models\AdmissionCycle;
use App\Models\Program;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdmissionApplicationController extends Controller
{
    public function index(Request $request)
    {
        $query = AdmissionApplication::with(['cycle', 'program.college']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('cycle_id')) {
            $query->where('admission_cycle_id', $request->cycle_id);
        }

        if ($request->filled('program_id')) {
            $query->where('program_id', $request->program_id);
        }

        $filteredCount = (clone $query)->count();
        $applications = $query->latest()->paginate(20)->withQueryString();
        $cycles = AdmissionCycle::orderByDesc('id')->get();
        $programs = Program::ordered()->get();
        $statuses = AdmissionApplicationStatus::cases();

        $stats = [
            'total' => AdmissionApplication::count(),
            'pending' => AdmissionApplication::where('status', AdmissionApplicationStatus::Pending->value)->count(),
            'accepted' => AdmissionApplication::where('status', AdmissionApplicationStatus::Accepted->value)->count(),
            'rejected' => AdmissionApplication::where('status', AdmissionApplicationStatus::Rejected->value)->count(),
            'filtered' => $filteredCount,
        ];

        return view('admin.admission.applications.index', compact('applications', 'cycles', 'programs', 'statuses', 'stats'));
    }

    public function show(AdmissionApplication $application)
    {
        $application->load(['cycle', 'program.college', 'program.department']);
        $statuses = AdmissionApplicationStatus::cases();

        return view('admin.admission.applications.show', compact('application', 'statuses'));
    }

    public function updateStatus(Request $request, AdmissionApplication $application)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::enum(AdmissionApplicationStatus::class)],
            'notes' => 'nullable|string',
        ], [
            'status.required' => 'حالة الطلب مطلوبة.',
        ]);

        $application->update([
            'status' => $validated['status'],
            'notes' => $validated['notes'] ?? $application->notes,
        ]);

        return back()->with('success', 'تم تحديث حالة الطلب بنجاح');
    }

    public function export(Request $request): StreamedResponse
    {
        $query = AdmissionApplication::with(['cycle', 'program']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('reference_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('cycle_id')) {
            $query->where('admission_cycle_id', $request->cycle_id);
        }

        $applications = $query->latest()->get();

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="admission-applications-' . date('Y-m-d') . '.csv"',
        ];

        return response()->stream(function () use ($applications) {
            $handle = fopen('php://output', 'w');
            fprintf($handle, chr(0xEF) . chr(0xBB) . chr(0xBF));
            fputcsv($handle, [
                'رقم المرجع', 'الاسم', 'البريد', 'الهاتف', 'البرنامج', 'الدورة', 'الحالة', 'تاريخ التقديم',
            ], ',');

            foreach ($applications as $app) {
                $status = $app->status instanceof AdmissionApplicationStatus
                    ? $app->status->label()
                    : $app->status;

                fputcsv($handle, [
                    $app->reference_number,
                    $app->full_name,
                    $app->email,
                    $app->phone,
                    $app->program?->name,
                    $app->cycle?->name,
                    $status,
                    $app->created_at?->format('Y-m-d H:i'),
                ], ',');
            }

            fclose($handle);
        }, 200, $headers);
    }
}
