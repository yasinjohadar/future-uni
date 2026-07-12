<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseSection extends Model
{
    protected $fillable = [
        'program_course_id', 'academic_term_id', 'staff_member_id', 'instructor_user_id',
        'section_code', 'capacity', 'days', 'starts_at', 'ends_at', 'room', 'is_active',
    ];

    protected $casts = [
        'days' => 'array',
        'capacity' => 'integer',
        'is_active' => 'boolean',
    ];

    public const DAY_LABELS = [
        0 => 'الأحد',
        1 => 'الإثنين',
        2 => 'الثلاثاء',
        3 => 'الأربعاء',
        4 => 'الخميس',
        5 => 'الجمعة',
        6 => 'السبت',
    ];

    public function programCourse(): BelongsTo
    {
        return $this->belongsTo(ProgramCourse::class);
    }

    public function academicTerm(): BelongsTo
    {
        return $this->belongsTo(AcademicTerm::class);
    }

    public function staffMember(): BelongsTo
    {
        return $this->belongsTo(StaffMember::class);
    }

    public function instructor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'instructor_user_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    public function attendanceSessions(): HasMany
    {
        return $this->hasMany(AttendanceSession::class);
    }

    public function announcements(): HasMany
    {
        return $this->hasMany(Announcement::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function enrolledCount(): int
    {
        return $this->enrollments()->where('status', 'enrolled')->count();
    }

    public function hasCapacity(): bool
    {
        return $this->enrolledCount() < $this->capacity;
    }

    public function getDaysLabelAttribute(): string
    {
        $days = $this->days ?? [];

        return collect($days)
            ->map(fn ($day) => self::DAY_LABELS[(int) $day] ?? $day)
            ->implode('، ') ?: '—';
    }

    public function getTimeRangeAttribute(): string
    {
        if (! $this->starts_at && ! $this->ends_at) {
            return '—';
        }

        $start = $this->starts_at ? substr((string) $this->starts_at, 0, 5) : '';
        $end = $this->ends_at ? substr((string) $this->ends_at, 0, 5) : '';

        return trim("{$start} – {$end}", ' –');
    }

    public function getInstructorNameAttribute(): string
    {
        return $this->staffMember?->name
            ?? $this->instructor?->name
            ?? '—';
    }
}
