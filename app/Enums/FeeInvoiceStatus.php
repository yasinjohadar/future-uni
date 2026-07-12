<?php

namespace App\Enums;

enum FeeInvoiceStatus: string
{
    case Pending = 'pending';
    case Partial = 'partial';
    case Paid = 'paid';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'مستحق',
            self::Partial => 'مدفوع جزئياً',
            self::Paid => 'مدفوع',
            self::Cancelled => 'ملغى',
        };
    }
}
