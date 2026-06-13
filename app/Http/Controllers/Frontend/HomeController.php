<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use App\Models\AdmissionCycle;
use App\Models\College;
use App\Models\HomepageHeroSlide;
use App\Models\HomepageStat;
use App\Models\Program;
use App\Models\StaffMember;
use App\Models\BlogPost;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $blogPosts = BlogPost::published()
            ->with('category')
            ->latest('published_at')
            ->take(6)
            ->get();

        $colleges = College::active()->ordered()->take(6)->get();
        $programs = Program::active()->with('college')->ordered()->take(6)->get();
        $staffMembers = StaffMember::active()->featured()->ordered()->take(8)->get();
        $heroSlides = HomepageHeroSlide::active()->ordered()->get();
        $homepageStats = HomepageStat::active()->ordered()->get();
        $accreditations = Accreditation::active()->ordered()->get();

        return view('frontend.pages.index', compact(
            'blogPosts',
            'colleges',
            'programs',
            'staffMembers',
            'heroSlides',
            'homepageStats',
            'accreditations'
        ));
    }
}
