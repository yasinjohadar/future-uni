<?php

namespace App\Support;

use Illuminate\Support\Collection;

class GpaCalculator
{
    /**
     * @param  Collection<int, \App\Models\Grade>|\App\Models\Grade[]  $grades
     */
    public static function compute(Collection|array $grades): ?float
    {
        $totalPoints = 0.0;
        $totalCredits = 0;

        foreach ($grades as $grade) {
            $credits = (int) ($grade->enrollment?->courseSection?->programCourse?->credits ?? 0);

            if ($credits <= 0 || blank($grade->letter)) {
                continue;
            }

            $totalPoints += GradeLetter::points($grade->letter) * $credits;
            $totalCredits += $credits;
        }

        return $totalCredits > 0 ? round($totalPoints / $totalCredits, 2) : null;
    }
}
