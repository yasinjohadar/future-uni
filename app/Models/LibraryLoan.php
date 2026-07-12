<?php

namespace App\Models;

use App\Enums\LibraryLoanStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LibraryLoan extends Model
{
    protected $fillable = [
        'student_id', 'library_book_id', 'borrowed_at', 'due_at', 'returned_at', 'status', 'notes',
    ];

    protected $casts = [
        'borrowed_at' => 'datetime',
        'due_at' => 'datetime',
        'returned_at' => 'datetime',
        'status' => LibraryLoanStatus::class,
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(LibraryBook::class, 'library_book_id');
    }

    public function isActive(): bool
    {
        return in_array($this->status, [LibraryLoanStatus::Borrowed, LibraryLoanStatus::Overdue], true);
    }
}
