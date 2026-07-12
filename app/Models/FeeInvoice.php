<?php

namespace App\Models;

use App\Enums\FeeInvoiceStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeeInvoice extends Model
{
    protected $fillable = [
        'student_id', 'title', 'amount', 'paid_amount', 'due_date', 'status', 'notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
        'due_date' => 'date',
        'status' => FeeInvoiceStatus::class,
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(FeePayment::class);
    }

    public function remaining(): float
    {
        return max(0, (float) $this->amount - (float) $this->paid_amount);
    }

    public function syncStatus(): void
    {
        if ($this->status === FeeInvoiceStatus::Cancelled) {
            return;
        }

        $paid = (float) $this->paid_amount;
        $amount = (float) $this->amount;

        $this->status = match (true) {
            $paid <= 0 => FeeInvoiceStatus::Pending,
            $paid >= $amount => FeeInvoiceStatus::Paid,
            default => FeeInvoiceStatus::Partial,
        };
    }
}
