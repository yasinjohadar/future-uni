<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            PermissionSeeder::class,
            UniversityRolesSeeder::class,
            AdminUserSeeder::class,
            BlogCategorySeeder::class,
            BlogTagSeeder::class,
            BlogPostSeeder::class,
            UniversitySeeder::class,
            UniversityRichContentSeeder::class,
            UniversityStaffRichContentSeeder::class,
            ResearchCentersSeeder::class,
            LibraryCategoriesSeeder::class,
            LibraryBooksSeeder::class,
            LibrarySettingsSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@example.com',
        ]);
    }
}
