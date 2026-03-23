<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_id',
        'category_id',
        'limit_amount',
        'month',
        'year',
    ];

    protected function casts(): array
    {
        return [
            'limit_amount' => 'decimal:2',
            'month'        => 'integer',
            'year'         => 'integer',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────────

    public function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    /** How much has been spent vs. this budget in the given period */
    public function spentAmount(): float
    {
        return (float) $this->couple
            ->transactions()
            ->where('category_id', $this->category_id)
            ->where('type', 'expense')
            ->whereYear('transaction_date', $this->year)
            ->whereMonth('transaction_date', $this->month)
            ->sum('amount');
    }

    public function remainingAmount(): float
    {
        return max(0, (float) $this->limit_amount - $this->spentAmount());
    }

    public function usagePercentage(): float
    {
        if ($this->limit_amount <= 0) return 0;
        return min(100, round(($this->spentAmount() / $this->limit_amount) * 100, 2));
    }

    // ── Scopes ─────────────────────────────────────────────────────────────

    public function scopeForPeriod($query, int $year, int $month)
    {
        return $query->where('year', $year)->where('month', $month);
    }
}
