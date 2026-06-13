<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AdmissionCycle extends Model
{
    protected $fillable = [
        'name', 'academic_year', 'start_date', 'end_date', 'is_open', 'description',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'is_open' => 'boolean',
    ];

    public function applications(): HasMany
    {
        return $this->hasMany(AdmissionApplication::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('is_open', true);
    }
}
