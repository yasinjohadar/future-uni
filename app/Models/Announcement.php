<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    protected $fillable = [
        'title', 'body', 'audience', 'college_id', 'program_id', 'course_section_id',
        'published_at', 'is_active', 'created_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function college(): BelongsTo
    {
        return $this->belongsTo(College::class);
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function courseSection(): BelongsTo
    {
        return $this->belongsTo(CourseSection::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('is_active', true)
            ->whereNotNull('published_at')
            ->where('published_at', '<=', now());
    }

    public function scopeVisibleToStudent(Builder $query, Student $student): Builder
    {
        $collegeId = $student->program?->college_id;
        $programId = $student->program_id;
        $sectionIds = $student->enrollments()
            ->where('status', 'enrolled')
            ->pluck('course_section_id');

        return $query->published()->where(function (Builder $q) use ($collegeId, $programId, $sectionIds) {
            $q->where('audience', 'all')
                ->orWhere(function (Builder $q2) use ($collegeId) {
                    $q2->where('audience', 'college')->where('college_id', $collegeId);
                })
                ->orWhere(function (Builder $q3) use ($programId) {
                    $q3->where('audience', 'program')->where('program_id', $programId);
                })
                ->orWhere(function (Builder $q4) use ($sectionIds) {
                    $q4->where('audience', 'section')
                        ->whereIn('course_section_id', $sectionIds);
                });
        });
    }
}
