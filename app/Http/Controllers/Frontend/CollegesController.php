<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\College;
use Illuminate\View\View;

class CollegesController extends Controller
{
    public function index(): View
    {
        $colleges = College::active()->ordered()->get();

        $highlights = [
            'colleges' => $colleges->count(),
            'programs' => $colleges->sum('programs_count'),
            'departments' => $colleges->sum('departments_count'),
        ];

        return view('frontend.pages.colleges', compact('colleges', 'highlights'));
    }

    public function show(string $slug): View
    {
        $college = College::where('slug', $slug)
            ->where('is_active', true)
            ->with(['departments' => fn ($q) => $q->active()->ordered(), 'programs' => fn ($q) => $q->active()->ordered(), 'dean'])
            ->firstOrFail();

        return view('frontend.pages.college-detail', compact('college'));
    }
}
