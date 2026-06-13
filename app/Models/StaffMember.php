<?php

namespace App\Models;

use App\Enums\StaffType;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class StaffMember extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'slug', 'type', 'name', 'position', 'specialty', 'academic_title', 'bio',
        'email', 'phone', 'office', 'stats', 'education', 'experience_history',
        'publications', 'awards', 'skills',
        'photo', 'icon', 'college_id', 'department_id', 'program_id',
        'sort_order', 'is_featured', 'is_active',
    ];

    protected $casts = [
        'type' => StaffType::class,
        'stats' => 'array',
        'education' => 'array',
        'experience_history' => 'array',
        'publications' => 'array',
        'awards' => 'array',
        'skills' => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOfType($query, StaffType|string $type)
    {
        $value = $type instanceof StaffType ? $type->value : $type;

        return $query->where('type', $value);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
