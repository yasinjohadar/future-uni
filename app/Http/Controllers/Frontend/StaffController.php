<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\StaffMember;
use App\Enums\StaffType;
use Illuminate\View\View;

class StaffController extends Controller
{
    public function index(): View
    {
        $leadership = StaffMember::active()->ofType(StaffType::Leadership)->ordered()->get();
        $deans = StaffMember::active()->ofType(StaffType::Dean)->with('college')->ordered()->get();

        return view('frontend.pages.staff', compact('leadership', 'deans'));
    }

    public function show(string $slug): View
    {
        $member = StaffMember::where('slug', $slug)->where('is_active', true)
            ->with(['college', 'department', 'program'])
            ->firstOrFail();

        $relatedMembers = StaffMember::query()
            ->where('id', '!=', $member->id)
            ->where('is_active', true)
            ->when($member->department_id, fn ($q) => $q->where('department_id', $member->department_id))
            ->when(! $member->department_id && $member->college_id, fn ($q) => $q->where('college_id', $member->college_id))
            ->when(! $member->college_id, fn ($q) => $q->where('type', $member->type))
            ->with('college')
            ->ordered()
            ->limit(6)
            ->get();

        return view('frontend.pages.staff-detail', compact('member', 'relatedMembers'));
    }
}
