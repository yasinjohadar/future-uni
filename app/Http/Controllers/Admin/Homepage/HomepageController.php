<?php

namespace App\Http\Controllers\Admin\Homepage;

use App\Http\Controllers\Controller;
use App\Models\Accreditation;
use App\Models\HomepageHeroSlide;
use App\Models\HomepageStat;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $heroSlides = HomepageHeroSlide::ordered()->get();
        $stats = HomepageStat::ordered()->get();
        $accreditations = Accreditation::ordered()->get();

        $summary = [
            'hero_slides' => HomepageHeroSlide::count(),
            'hero_active' => HomepageHeroSlide::where('is_active', true)->count(),
            'stats' => HomepageStat::count(),
            'accreditations' => Accreditation::count(),
        ];

        return view('admin.homepage.index', compact('heroSlides', 'stats', 'accreditations', 'summary'));
    }

    // Hero Slides
    public function storeHeroSlide(Request $request)
    {
        $validated = $this->validateHeroSlide($request);
        $validated['is_active'] = $this->resolveBool($request, 'is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? ((HomepageHeroSlide::max('sort_order') ?? 0) + 1);

        HomepageHeroSlide::create($validated);

        return back()->with('success', 'تم إضافة الشريحة بنجاح');
    }

    public function updateHeroSlide(Request $request, HomepageHeroSlide $heroSlide)
    {
        $validated = $this->validateHeroSlide($request);
        $validated['is_active'] = $this->resolveBool($request, 'is_active');

        $heroSlide->update($validated);

        return back()->with('success', 'تم تحديث الشريحة بنجاح');
    }

    public function destroyHeroSlide(HomepageHeroSlide $heroSlide)
    {
        $heroSlide->delete();

        return back()->with('success', 'تم حذف الشريحة بنجاح');
    }

    public function toggleHeroSlideActive(HomepageHeroSlide $heroSlide)
    {
        $heroSlide->update(['is_active' => ! $heroSlide->is_active]);

        return back()->with('success', 'تم تحديث حالة الشريحة');
    }

    // Stats
    public function storeStat(Request $request)
    {
        $validated = $this->validateStat($request);
        $validated['is_active'] = $this->resolveBool($request, 'is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? ((HomepageStat::max('sort_order') ?? 0) + 1);

        HomepageStat::create($validated);

        return back()->with('success', 'تم إضافة الإحصائية بنجاح');
    }

    public function updateStat(Request $request, HomepageStat $stat)
    {
        $validated = $this->validateStat($request);
        $validated['is_active'] = $this->resolveBool($request, 'is_active');

        $stat->update($validated);

        return back()->with('success', 'تم تحديث الإحصائية بنجاح');
    }

    public function destroyStat(HomepageStat $stat)
    {
        $stat->delete();

        return back()->with('success', 'تم حذف الإحصائية بنجاح');
    }

    public function toggleStatActive(HomepageStat $stat)
    {
        $stat->update(['is_active' => ! $stat->is_active]);

        return back()->with('success', 'تم تحديث حالة الإحصائية');
    }

    // Accreditations
    public function storeAccreditation(Request $request)
    {
        $validated = $this->validateAccreditation($request);
        $validated['is_active'] = $this->resolveBool($request, 'is_active');
        $validated['sort_order'] = $validated['sort_order'] ?? ((Accreditation::max('sort_order') ?? 0) + 1);

        Accreditation::create($validated);

        return back()->with('success', 'تم إضافة الاعتماد بنجاح');
    }

    public function updateAccreditation(Request $request, Accreditation $accreditation)
    {
        $validated = $this->validateAccreditation($request);
        $validated['is_active'] = $this->resolveBool($request, 'is_active');

        $accreditation->update($validated);

        return back()->with('success', 'تم تحديث الاعتماد بنجاح');
    }

    public function destroyAccreditation(Accreditation $accreditation)
    {
        $accreditation->delete();

        return back()->with('success', 'تم حذف الاعتماد بنجاح');
    }

    public function toggleAccreditationActive(Accreditation $accreditation)
    {
        $accreditation->update(['is_active' => ! $accreditation->is_active]);

        return back()->with('success', 'تم تحديث حالة الاعتماد');
    }

    private function validateHeroSlide(Request $request): array
    {
        return $request->validate([
            'badge' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'title_accent' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'primary_btn_label' => 'nullable|string|max:100',
            'primary_btn_url' => 'nullable|string|max:500',
            'secondary_btn_label' => 'nullable|string|max:100',
            'secondary_btn_url' => 'nullable|string|max:500',
            'background_image' => 'nullable|string|max:500',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'title.required' => 'عنوان الشريحة مطلوب.',
        ]);
    }

    private function validateStat(Request $request): array
    {
        return $request->validate([
            'icon' => 'nullable|string|max:100',
            'value' => 'required|string|max:100',
            'label' => 'required|string|max:255',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'value.required' => 'قيمة الإحصائية مطلوبة.',
            'label.required' => 'تسمية الإحصائية مطلوبة.',
        ]);
    }

    private function validateAccreditation(Request $request): array
    {
        return $request->validate([
            'name' => 'required|string|max:255',
            'icon' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ], [
            'name.required' => 'اسم الاعتماد مطلوب.',
        ]);
    }

    private function resolveBool(Request $request, string $field): int
    {
        return $request->has($field) && $request->input($field) == '1' ? 1 : 0;
    }
}
