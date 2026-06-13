<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ResearchCenter extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug', 'name', 'icon', 'description', 'long_description',
        'college_id', 'director_id', 'director_title', 'email', 'phone',
        'established', 'projects_count', 'publications_count',
        'stats', 'focus_areas', 'active_projects', 'partners',
        'featured_image', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'projects_count' => 'integer',
        'publications_count' => 'integer',
        'stats' => 'array',
        'focus_areas' => 'array',
        'active_projects' => 'array',
        'partners' => 'array',
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function director(): BelongsTo
    {
        return $this->belongsTo(StaffMember::class, 'director_id');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function directorDisplayName(): string
    {
        return $this->director?->name ?? $this->director_title ?? '—';
    }

    public function collegeDisplayName(): string
    {
        return $this->college?->name ?? '—';
    }

    public function statValue(string $key, mixed $default = 0): mixed
    {
        return data_get($this->stats, $key, $default);
    }
}
