<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Doctor\Concerns\AuthorizesDoctorSection;
use App\Http\Requests\Doctor\ProfileUpdateRequest;
use App\Models\AcademicTerm;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use AuthorizesDoctorSection;

    public function show(): View
    {
        $user = Auth::user();
        $currentTerm = AcademicTerm::current()->first();

        $sections = $this->doctorSectionsQuery()
            ->with(['programCourse', 'academicTerm'])
            ->when($currentTerm, fn ($q) => $q->where('academic_term_id', $currentTerm->id))
            ->orderBy('starts_at')
            ->get();

        return view('doctor.pages.profile.show', [
            'user' => $user,
            'sections' => $sections,
            'currentTerm' => $currentTerm,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        Auth::user()->update($request->validated());

        return redirect()
            ->route('doctor.profile.show')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح.');
    }
}
