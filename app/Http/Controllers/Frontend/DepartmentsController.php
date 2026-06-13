<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\College;
use App\Models\Department;
use App\Models\StaffMember;
use Illuminate\View\View;

class DepartmentsController extends Controller
{
    public function show(string $collegeSlug, string $departmentSlug): View
    {
        $college = College::where('slug', $collegeSlug)
            ->where('is_active', true)
            ->with(['dean', 'departments' => fn ($q) => $q->active()->ordered()])
            ->firstOrFail();

        $department = Department::where('college_id', $college->id)
            ->where('slug', $departmentSlug)
            ->where('is_active', true)
            ->with(['college', 'programs' => fn ($q) => $q->active()->ordered()])
            ->firstOrFail();

        $siblingDepartments = $college->departments->where('id', '!=', $department->id)->values();

        $facultyMembers = StaffMember::query()
            ->where('department_id', $department->id)
            ->active()
            ->ordered()
            ->limit(6)
            ->get();

        return view('frontend.pages.department-detail', compact(
            'college',
            'department',
            'siblingDepartments',
            'facultyMembers',
        ));
    }
}
