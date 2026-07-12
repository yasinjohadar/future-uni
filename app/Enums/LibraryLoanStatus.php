<?php

namespace App\Enums;

enum LibraryLoanStatus: string
{
    case Borrowed = 'borrowed';
    case Returned = 'returned';
    case Overdue = 'overdue';

    public function label(): string
    {
        return match ($this) {
            self::Borrowed => 'مستعار',
            self::Returned => 'مُرجع',
            self::Overdue => 'متأخر',
        };
    }
}
