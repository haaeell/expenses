<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'couple_id',
        'user_id',
        'wallet_id',
        'category_id',
        'type',
        'amount',
        'description',
        'mood',
        'receipt_photo',
        'tags',
        'is_recurring',
        'recurring_freq',
        'transaction_date',
    ];

    protected function casts(): array
    {
        return [
            'amount'           => 'decimal:2',
            'tags'             => 'array',
            'is_recurring'     => 'boolean',
            'transaction_date' => 'date',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────────

    public function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function wallet(): BelongsTo
    {
        return $this->belongsTo(Wallet::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function goalContribution(): HasOne
    {
        return $this->hasOne(GoalContribution::class);
    }

    public function splitBill(): HasOne
    {
        return $this->hasOne(SplitBill::class);
    }

    public function reminder(): HasOne
    {
        return $this->hasOne(Reminder::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────────

    public function scopeExpenses($query)
    {
        return $query->where('type', 'expense');
    }

    public function scopeIncome($query)
    {
        return $query->where('type', 'income');
    }

    public function scopeForMonth($query, int $year, int $month)
    {
        return $query->whereYear('transaction_date', $year)
                     ->whereMonth('transaction_date', $month);
    }
}
