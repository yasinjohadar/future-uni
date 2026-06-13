<?php

namespace App\Http\Controllers\Admin\Concerns;

use Illuminate\Support\Str;

trait GeneratesArabicSlug
{
    protected function generateUniqueSlug(
        string $name,
        string $modelClass,
        ?int $excludeId = null,
        array $scope = []
    ): string {
        $slug = Str::slug($name, '-', 'ar');
        $slug = preg_replace('/\s+/', '-', trim($slug));
        $slug = preg_replace('/[^\p{Arabic}a-zA-Z0-9-]/u', '', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');

        if ($slug === '') {
            $slug = 'item-' . time();
        }

        $counter = 1;
        $originalSlug = $slug;

        while ($this->slugExists($modelClass, $slug, $excludeId, $scope)) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }

    protected function slugExists(
        string $modelClass,
        string $slug,
        ?int $excludeId = null,
        array $scope = []
    ): bool {
        $query = $modelClass::query()->where('slug', $slug);

        if ($excludeId !== null) {
            $query->where('id', '!=', $excludeId);
        }

        foreach ($scope as $column => $value) {
            $query->where($column, $value);
        }

        return $query->exists();
    }

    protected function resolveIsActive($request, string $field = 'is_active'): int
    {
        return $request->has($field) && $request->input($field) == '1' ? 1 : 0;
    }
}
