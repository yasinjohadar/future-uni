<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LibrarySetting extends Model
{
    protected $fillable = [
        'digital_references', 'reading_seats',
    ];

    protected $casts = [
        'reading_seats' => 'integer',
    ];

    public static function instance(): self
    {
        return static::query()->firstOrCreate([], [
            'digital_references' => '850+',
            'reading_seats' => 320,
        ]);
    }
}
