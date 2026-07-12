<?php

namespace App\Http\Controllers\Student\Concerns;

use App\Models\Student;
use Illuminate\Support\Facades\Auth;

trait ResolvesStudent
{
    protected function student(): Student
    {
        return Student::where('user_id', Auth::id())
            ->with('program.college')
            ->firstOrFail();
    }
}
