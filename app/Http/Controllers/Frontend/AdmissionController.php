<?php

namespace App\Http\Controllers\Frontend;

use App\Enums\AdmissionApplicationStatus;
use App\Http\Controllers\Controller;
use App\Models\AdmissionApplication;
use App\Models\AdmissionCycle;
use App\Models\Program;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdmissionController extends Controller
{
    public function index(): View
    {
        $programs = Program::active()->with('college')->ordered()->get();
        $openCycle = AdmissionCycle::open()->latest()->first();

        return view('frontend.pages.admission', compact('programs', 'openCycle'));
    }

    public function store(Request $request): RedirectResponse
    {
        $openCycle = AdmissionCycle::open()->latest()->first();

        if (! $openCycle) {
            return back()->withInput()->with('error', 'بوابة القبول مغلقة حالياً.');
        }

        $validated = $request->validate([
            'firstName' => 'required|string|max:100',
            'lastName' => 'required|string|max:100',
            'nationalId' => 'required|string|max:50',
            'birthDate' => 'required|date',
            'gender' => 'required|in:male,female',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:30',
            'city' => 'required|string|max:100',
            'program_id' => 'required|exists:programs,id',
            'gpa' => 'required|numeric|min:0|max:100',
            'certificate' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'idCard' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
            'agreeTerms' => 'accepted',
        ], [
            'firstName.required' => 'الاسم الأول مطلوب.',
            'lastName.required' => 'اسم العائلة مطلوب.',
            'program_id.required' => 'يجب اختيار البرنامج.',
            'agreeTerms.accepted' => 'يجب الموافقة على الشروط.',
        ]);

        $documents = [];
        foreach (['certificate' => 'certificate', 'idCard' => 'id_card', 'qudratResult' => 'qudrat', 'photo' => 'photo'] as $field => $type) {
            if ($request->hasFile($field)) {
                $path = $request->file($field)->store('admissions/' . date('Y/m'), 'public');
                $documents[] = ['type' => $type, 'path' => $path];
            }
        }

        $application = AdmissionApplication::create([
            'admission_cycle_id' => $openCycle->id,
            'program_id' => $validated['program_id'],
            'full_name' => trim($validated['firstName'] . ' ' . $validated['lastName']),
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'national_id' => $validated['nationalId'],
            'birth_date' => $validated['birthDate'],
            'gender' => $validated['gender'],
            'high_school_gpa' => (string) $validated['gpa'],
            'city' => $validated['city'],
            'status' => AdmissionApplicationStatus::Pending,
            'documents' => $documents,
            'agreed_terms' => true,
            'notes' => $request->input('notes'),
        ]);

        return back()->with('success', 'تم استلام طلبك بنجاح. رقم المرجع: ' . $application->reference_number);
    }
}
