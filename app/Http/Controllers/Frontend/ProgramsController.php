<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Program;
use Illuminate\View\View;

class ProgramsController extends Controller
{
    public function index(): View
    {
        $programs = Program::active()->with('college')->ordered()->get();

        return view('frontend.pages.programs', compact('programs'));
    }

    public function show(string $slug): View
    {
        $program = Program::where('slug', $slug)
            ->where('is_active', true)
            ->with(['college.dean', 'department', 'courses'])
            ->firstOrFail();

        $relatedPrograms = Program::query()
            ->where('id', '!=', $program->id)
            ->where('is_active', true)
            ->when($program->department_id, fn ($q) => $q->where('department_id', $program->department_id))
            ->when(! $program->department_id && $program->college_id, fn ($q) => $q->where('college_id', $program->college_id))
            ->ordered()
            ->limit(6)
            ->get();

        return view('frontend.pages.program-detail', compact('program', 'relatedPrograms'));
    }
}
