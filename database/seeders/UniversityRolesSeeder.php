<?php

namespace Database\Seeders;

use App\Support\PermissionRegistry;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UniversityRolesSeeder extends Seeder
{
    public function run(): void
    {
        PermissionRegistry::syncToDatabase();

        $roles = [
            'super-admin' => Permission::all()->pluck('name')->all(),
            'content-editor' => [
                'dashboard-view',
                'blog-post-list', 'blog-post-create', 'blog-post-edit', 'blog-post-delete',
                'blog-post-toggle-featured', 'blog-post-toggle-publish',
                'blog-category-list', 'blog-category-create', 'blog-category-edit', 'blog-category-delete',
                'blog-tag-list', 'blog-tag-create', 'blog-tag-edit', 'blog-tag-delete',
                'blog-ai-create', 'blog-ai-generate',
                'settings-site-view', 'settings-site-edit',
                'homepage-list', 'homepage-edit',
            ],
            'admissions-officer' => [
                'dashboard-view',
                'admission-application-list', 'admission-application-show', 'admission-application-update',
                'admission-application-export',
                'admission-cycle-list', 'admission-cycle-create', 'admission-cycle-edit',
                'program-list',
            ],
            'registrar' => [
                'dashboard-view',
                'college-list', 'college-create', 'college-edit',
                'department-list', 'department-create', 'department-edit',
                'program-list', 'program-create', 'program-edit',
                'staff-list', 'staff-create', 'staff-edit',
                'student-list', 'student-create', 'student-edit',
                'research-center-list', 'research-center-create', 'research-center-edit',
                'library-category-list', 'library-category-create', 'library-category-edit',
                'library-book-list', 'library-book-create', 'library-book-edit',
                'library-settings-edit',
            ],
            'student' => [
                'dashboard-view',
            ],
            'doctor' => [
                'dashboard-view',
            ],
        ];

        foreach ($roles as $name => $permissions) {
            $role = Role::firstOrCreate(['name' => $name, 'guard_name' => 'web']);
            $role->syncPermissions($permissions);
        }

        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminRole->syncPermissions(Permission::all());
        }
    }
}
