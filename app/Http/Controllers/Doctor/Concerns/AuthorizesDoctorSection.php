<?php

namespace App\Http\Controllers\Doctor\Concerns;

use App\Models\CourseSection;
use Illuminate\Support\Facades\Auth;

trait AuthorizesDoctorSection
{
    protected function authorizeSection(CourseSection $section): void
    {
        abort_unless($section->instructor_user_id === Auth::id(), 403);
    }

    protected function doctorSectionsQuery()
    {
        return CourseSection::query()->where('instructor_user_id', Auth::id());
    }
}
