<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class SplitBill extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'couple_id',
        'paid_by',
        'transaction_id',
        'event_id',
        'total_amount',
        'split_type',
        'user1_amount',
        'user2_amount',
        'description',
        'is_settled',
        'settled_at',
    ];

    protected function casts(): array
    {
        return [
            'total_amount'  => 'decimal:2',
            'user1_amount'  => 'decimal:2',
            'user2_amount'  => 'decimal:2',
            'is_settled'    => 'boolean',
            'settled_at'    => 'datetime',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────────

    public function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }

    public function paidBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'paid_by');
    }

    public function transaction(): BelongsTo
    {
        return $this->belongsTo(Transaction::class);
    }

    public function event(): BelongsTo
    {
        return $this->belongsTo(SplitBillEvent::class, 'event_id');
    }

    // ── Scopes ─────────────────────────────────────────────────────────────

    public function scopeUnsettled($query)
    {
        return $query->where('is_settled', false);
    }
}
