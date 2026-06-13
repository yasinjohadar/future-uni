<?php

namespace App\Models;

use App\Enums\ProgramLevel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Program extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'college_id', 'department_id', 'slug', 'name', 'level', 'duration', 'credits',
        'students_count', 'faculty_count', 'description', 'requirements',
        'objectives', 'careers', 'featured_image', 'sort_order', 'is_active',
    ];

    protected $casts = [
        'objectives' => 'array',
        'careers' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
        'credits' => 'integer',
        'students_count' => 'integer',
        'faculty_count' => 'integer',
        'level' => ProgramLevel::class,
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class);
    }

    public function courses(): HasMany
    {
        return $this->hasMany(ProgramCourse::class)->orderBy('sort_order');
    }

    public function admissionApplications(): HasMany
    {
        return $this->hasMany(AdmissionApplication::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    public function getLevelLabelAttribute(): string
    {
        return $this->level instanceof ProgramLevel ? $this->level->label() : '';
    }
}
