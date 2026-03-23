<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SplitBillEvent extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_id',
        'name',
        'emoji',
        'event_date',
        'is_closed',
        'closed_at',
    ];

    protected function casts(): array
    {
        return [
            'event_date' => 'date',
            'is_closed'  => 'boolean',
            'closed_at'  => 'datetime',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────────

    public function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }

    public function splitBills(): HasMany
    {
        return $this->hasMany(SplitBill::class, 'event_id');
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    public function totalAmount(): float
    {
        return (float) $this->splitBills()->sum('total_amount');
    }
}
