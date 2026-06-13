<?php

namespace Database\Seeders;

use App\Models\LibraryCategory;
use Illuminate\Database\Seeder;

class LibraryCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['slug' => 'engineering', 'name' => 'الهندسة', 'icon' => 'fa-gears', 'color' => '#0F172A', 'sort_order' => 1],
            ['slug' => 'medicine', 'name' => 'الطب', 'icon' => 'fa-stethoscope', 'color' => '#dc2626', 'sort_order' => 2],
            ['slug' => 'cs', 'name' => 'علوم الحاسب', 'icon' => 'fa-code', 'color' => '#059669', 'sort_order' => 3],
            ['slug' => 'business', 'name' => 'إدارة الأعمال', 'icon' => 'fa-chart-line', 'color' => '#d97706', 'sort_order' => 4],
            ['slug' => 'science', 'name' => 'العلوم', 'icon' => 'fa-atom', 'color' => '#7c3aed', 'sort_order' => 5],
            ['slug' => 'law', 'name' => 'القانون', 'icon' => 'fa-scale-balanced', 'color' => '#0891b2', 'sort_order' => 6],
            ['slug' => 'education', 'name' => 'التربية', 'icon' => 'fa-chalkboard-user', 'color' => '#be185d', 'sort_order' => 7],
        ];

        foreach ($categories as $category) {
            LibraryCategory::updateOrCreate(
                ['slug' => $category['slug']],
                array_merge($category, ['is_active' => true])
            );
        }
    }
}
