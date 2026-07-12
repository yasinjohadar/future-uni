<?php

namespace App\Http\Controllers\Doctor;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GradeController extends Controller
{
    public function update(Request $request, Grade $grade): RedirectResponse
    {
        $this->authorizeGrade($grade);

        $validated = $request->validate([
            'midterm' => ['nullable', 'numeric', 'min:0', 'max:100'],
            'final' => ['nullable', 'numeric', 'min:0', 'max:100'],
        ]);

        $grade->fill($validated);
        $grade->recalculate();
        $grade->save();

        return back()->with('success', 'تم حفظ الدرجات بنجاح.');
    }

    public function publish(Grade $grade): RedirectResponse
    {
        $this->authorizeGrade($grade);

        if ($grade->total === null) {
            return back()->with('error', 'لا يمكن نشر الدرجة قبل إدخال الدرجات.');
        }

        $grade->update(['published_at' => now()]);

        return back()->with('success', 'تم نشر الدرجة للطالب.');
    }

    protected function authorizeGrade(Grade $grade): void
    {
        $grade->loadMissing('enrollment.courseSection');

        abort_unless(
            $grade->enrollment?->courseSection?->instructor_user_id === Auth::id(),
            403
        );
    }
}
