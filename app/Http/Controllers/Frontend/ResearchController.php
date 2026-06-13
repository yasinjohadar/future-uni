<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use App\Models\ResearchCenter;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResearchController extends Controller
{
    public function index(): View
    {
        $centers = ResearchCenter::active()->ordered()->get();

        $partnerCount = $centers
            ->flatMap(fn (ResearchCenter $center) => $center->partners ?? [])
            ->unique()
            ->count();

        $highlights = [
            'centers' => $centers->count(),
            'projects' => $centers->sum('projects_count'),
            'publications' => $centers->sum('publications_count'),
            'partners' => $partnerCount,
        ];

        $latestPosts = BlogPost::published()
            ->with('category')
            ->latest('published_at')
            ->take(3)
            ->get();

        return view('frontend.pages.research', compact('centers', 'highlights', 'latestPosts'));
    }

    public function show(string $slug): View
    {
        $center = ResearchCenter::where('slug', $slug)
            ->where('is_active', true)
            ->with(['college', 'director'])
            ->firstOrFail();

        $relatedCenters = ResearchCenter::active()
            ->where('id', '!=', $center->id)
            ->ordered()
            ->limit(3)
            ->get();

        return view('frontend.pages.research-detail', compact('center', 'relatedCenters'));
    }

    public function legacyDetail(Request $request): RedirectResponse
    {
        if ($request->filled('id')) {
            $center = ResearchCenter::find($request->integer('id'));
            if ($center) {
                return redirect()->route('research.show', $center->slug, 301);
            }
        }

        return redirect()->route('research');
    }
}
