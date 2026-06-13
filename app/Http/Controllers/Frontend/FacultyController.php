<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\StaffMember;
use App\Enums\StaffType;
use Illuminate\View\View;

class FacultyController extends Controller
{
    public function index(): View
    {
        $faculty = StaffMember::active()
            ->ofType(StaffType::Faculty)
            ->with(['college', 'department'])
            ->ordered()
            ->get();

        return view('frontend.pages.faculty', compact('faculty'));
    }
}
