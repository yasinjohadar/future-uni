<?php

namespace App\Enums;

enum EnrollmentStatus: string
{
    case Enrolled = 'enrolled';
    case Dropped = 'dropped';
    case Completed = 'completed';

    public function label(): string
    {
        return match ($this) {
            self::Enrolled => 'مسجّل',
            self::Dropped => 'منسحب',
            self::Completed => 'مكتمل',
        };
    }
}
