<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProgramCourse extends Model
{
    protected $fillable = [
        'program_id', 'code', 'name', 'credits', 'semester', 'type', 'sort_order',
    ];

    protected $casts = [
        'credits' => 'integer',
        'semester' => 'integer',
        'sort_order' => 'integer',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(CourseSection::class);
    }
}
