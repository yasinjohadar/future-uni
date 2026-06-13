<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class LibraryBook extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug', 'title', 'author', 'library_category_id',
        'icon', 'color', 'isbn', 'publisher', 'edition',
        'publication_year', 'pages', 'language', 'rating',
        'is_available', 'copies_total', 'copies_available',
        'shelf_location', 'description', 'chapters', 'tags',
        'cover_image', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_available' => 'boolean',
        'sort_order' => 'integer',
        'pages' => 'integer',
        'copies_total' => 'integer',
        'copies_available' => 'integer',
        'rating' => 'decimal:1',
        'chapters' => 'array',
        'tags' => 'array',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(LibraryCategory::class, 'library_category_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('title');
    }

    public function scopeSearch($query, ?string $keyword)
    {
        if (blank($keyword)) {
            return $query;
        }

        $keyword = trim($keyword);

        return $query->where(function ($q) use ($keyword) {
            $q->where('title', 'like', "%{$keyword}%")
                ->orWhere('author', 'like', "%{$keyword}%")
                ->orWhere('isbn', 'like', "%{$keyword}%")
                ->orWhere('description', 'like', "%{$keyword}%")
                ->orWhereHas('category', fn ($cat) => $cat->where('name', 'like', "%{$keyword}%"))
                ->orWhere('tags', 'like', "%{$keyword}%");
        });
    }

    public function scopeInCategory($query, ?string $categorySlug)
    {
        if (blank($categorySlug) || $categorySlug === 'all') {
            return $query;
        }

        return $query->whereHas('category', fn ($q) => $q->where('slug', $categorySlug));
    }

    public function syncAvailability(): void
    {
        $this->is_available = $this->copies_available > 0;
    }
}
