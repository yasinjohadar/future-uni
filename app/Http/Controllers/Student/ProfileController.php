<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Student\Concerns\ResolvesStudent;
use App\Http\Requests\Student\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProfileController extends Controller
{
    use ResolvesStudent;

    public function show(): View
    {
        $student = $this->student()->load('user');

        return view('student.pages.profile.show', [
            'student' => $student,
            'user' => $student->user,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $student = $this->student();
        $student->user->update($request->validated());

        return redirect()
            ->route('student.profile.show')
            ->with('success', 'تم تحديث الملف الشخصي بنجاح.');
    }
}
