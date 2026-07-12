<?php

namespace App\Models;

use App\Support\GradeLetter;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Grade extends Model
{
    protected $fillable = [
        'enrollment_id', 'midterm', 'final', 'total', 'letter', 'published_at',
    ];

    protected $casts = [
        'midterm' => 'decimal:2',
        'final' => 'decimal:2',
        'total' => 'decimal:2',
        'published_at' => 'datetime',
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null;
    }

    public function recalculate(): void
    {
        if ($this->midterm === null && $this->final === null) {
            $this->total = null;
            $this->letter = null;

            return;
        }

        $mid = (float) ($this->midterm ?? 0);
        $final = (float) ($this->final ?? 0);
        $this->total = round(($mid * 0.4) + ($final * 0.6), 2);
        $this->letter = GradeLetter::fromTotal((float) $this->total);
    }

    public function scopePublished($query)
    {
        return $query->whereNotNull('published_at');
    }
}
