<?php

namespace App\Models;

use App\Enums\AdmissionApplicationStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class AdmissionApplication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference_number', 'admission_cycle_id', 'program_id', 'full_name', 'email',
        'phone', 'national_id', 'birth_date', 'gender', 'high_school_gpa', 'city',
        'notes', 'status', 'documents', 'agreed_terms',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'documents' => 'array',
        'agreed_terms' => 'boolean',
        'status' => AdmissionApplicationStatus::class,
    ];

    protected static function booted(): void
    {
        static::creating(function (AdmissionApplication $application) {
            if (empty($application->reference_number)) {
                do {
                    $ref = 'ADM-' . now()->format('Y') . '-' . strtoupper(Str::random(6));
                } while (static::where('reference_number', $ref)->exists());
                $application->reference_number = $ref;
            }
        });
    }

    public function cycle(): BelongsTo
    {
        return $this->belongsTo(AdmissionCycle::class, 'admission_cycle_id');
    }

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', AdmissionApplicationStatus::Pending->value);
    }
}
