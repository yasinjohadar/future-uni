<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class College extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug', 'name', 'category', 'icon', 'description', 'vision', 'mission',
        'established', 'students_count', 'building', 'accreditation', 'dean_id',
        'departments_count', 'programs_count', 'featured_image', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'departments_count' => 'integer',
        'programs_count' => 'integer',
    ];

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class)->orderBy('sort_order');
    }

    public function programs(): HasMany
    {
        return $this->hasMany(Program::class)->orderBy('sort_order');
    }

    public function staffMembers(): HasMany
    {
        return $this->hasMany(StaffMember::class);
    }

    public function dean(): BelongsTo
    {
        return $this->belongsTo(StaffMember::class, 'dean_id');
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
