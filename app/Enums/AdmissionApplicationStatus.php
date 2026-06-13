<?php

namespace App\Enums;

enum AdmissionApplicationStatus: string
{
    case Pending = 'pending';
    case Review = 'review';
    case Accepted = 'accepted';
    case Rejected = 'rejected';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'قيد الانتظار',
            self::Review => 'قيد المراجعة',
            self::Accepted => 'مقبول',
            self::Rejected => 'مرفوض',
        };
    }

    public function badgeClass(): string
    {
        return match ($this) {
            self::Pending => 'bg-warning',
            self::Review => 'bg-info',
            self::Accepted => 'bg-success',
            self::Rejected => 'bg-danger',
        };
    }
}
