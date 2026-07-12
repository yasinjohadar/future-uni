<?php

namespace App\Support;

class GradeLetter
{
    public static function fromTotal(?float $total): ?string
    {
        if ($total === null) {
            return null;
        }

        return match (true) {
            $total >= 90 => 'A',
            $total >= 85 => 'B+',
            $total >= 80 => 'B',
            $total >= 75 => 'C+',
            $total >= 70 => 'C',
            $total >= 60 => 'D',
            default => 'F',
        };
    }

    public static function points(?string $letter): float
    {
        return match ($letter) {
            'A' => 4.0,
            'B+' => 3.5,
            'B' => 3.0,
            'C+' => 2.5,
            'C' => 2.0,
            'D' => 1.0,
            'F' => 0.0,
            default => 0.0,
        };
    }
}
