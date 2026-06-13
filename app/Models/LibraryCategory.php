<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LibraryCategory extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug', 'name', 'icon', 'color', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function books(): HasMany
    {
        return $this->hasMany(LibraryBook::class);
    }

    public function activeBooks(): HasMany
    {
        return $this->hasMany(LibraryBook::class)->where('is_active', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
