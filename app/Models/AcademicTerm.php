<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicTerm extends Model
{
    protected $fillable = [
        'name', 'code', 'starts_at', 'ends_at',
        'registration_opens_at', 'registration_closes_at',
        'is_current', 'is_active',
    ];

    protected $casts = [
        'starts_at' => 'date',
        'ends_at' => 'date',
        'registration_opens_at' => 'datetime',
        'registration_closes_at' => 'datetime',
        'is_current' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function sections(): HasMany
    {
        return $this->hasMany(CourseSection::class);
    }

    public function scopeCurrent($query)
    {
        return $query->where('is_current', true);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function isRegistrationOpen(): bool
    {
        if (! $this->is_active || ! $this->registration_opens_at || ! $this->registration_closes_at) {
            return false;
        }

        $now = now();

        return $now->between($this->registration_opens_at, $this->registration_closes_at);
    }

    public function markAsCurrent(): void
    {
        static::query()->where('id', '!=', $this->id)->update(['is_current' => false]);
        $this->update(['is_current' => true]);
    }
}
