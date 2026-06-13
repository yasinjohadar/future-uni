<?php

namespace App\Enums;

enum StaffType: string
{
    case Leadership = 'leadership';
    case Dean = 'dean';
    case Faculty = 'faculty';

    public function label(): string
    {
        return match ($this) {
            self::Leadership => 'القيادة',
            self::Dean => 'عميد',
            self::Faculty => 'عضو هيئة تدريس',
        };
    }
}
