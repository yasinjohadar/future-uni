<?php

if (! function_exists('storage_disk')) {
    function storage_disk(string $diskName)
    {
        return app(\App\Services\Storage\AppStorageManager::class)->getDisk($diskName);
    }
}

if (! function_exists('media_public_url')) {
    /**
     * رابط عام للملف المخزّن (يفضّل السحابة عند توفر الملف هناك).
     */
    function media_public_url(?string $path): string
    {
        if ($path === null || $path === '') {
            return '';
        }

        $path = trim((string) $path);
        if (preg_match('#^https?://[^/]+/storage/(.+)$#i', $path, $m)) {
            $path = $m[1];
        }

        $normalized = ltrim(str_replace('\\', '/', $path), '/');

        try {
            return \App\Services\Storage\MediaStorageService::url($normalized);
        } catch (\Throwable $e) {
            try {
                return \Illuminate\Support\Facades\Storage::disk(
                    config('storage.fallback_disk', 'public')
                )->url($normalized);
            } catch (\Throwable $inner) {
                $p = ltrim(str_replace('\\', '/', $normalized), '/');

                return '/storage/'.$p;
            }
        }
    }
}

if (! function_exists('frontend_link')) {
    /**
     * Resolve a frontend nav/footer link from route or url key.
     */
    function frontend_link(array $item): string
    {
        if (! empty($item['route'])) {
            return route($item['route']);
        }

        return $item['url'] ?? '#';
    }
}

if (! function_exists('college_card_image')) {
    /**
     * Background image URL for a college card on the listing page.
     */
    function college_card_image(\App\Models\College $college, int $index = 0): string
    {
        if (! empty($college->featured_image)) {
            return media_public_url($college->featured_image);
        }

        $images = config('frontend-colleges.card_images', []);

        return $images[$index % max(count($images), 1)] ?? $images[0] ?? '';
    }
}

if (! function_exists('college_fa_icon')) {
    /**
     * Normalize college icon class (DB stores "fa-gears", needs "fas fa-gears").
     */
    function college_fa_icon(?string $icon, string $fallback = 'fa-building-columns'): string
    {
        $icon = trim((string) ($icon ?: $fallback));

        if (str_contains($icon, ' ')) {
            return $icon;
        }

        return 'fas ' . $icon;
    }
}
