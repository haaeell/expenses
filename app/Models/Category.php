<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_id',
        'name',
        'emoji',
        'type',
        'color_hex',
        'is_default',
        'sort_order',
    ];

    protected function casts(): array
    {
        return [
            'is_default' => 'boolean',
            'sort_order' => 'integer',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────────

    public function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function recurringTransactions(): HasMany
    {
        return $this->hasMany(RecurringTransaction::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────────

    public function scopeDefaults($query)
    {
        return $query->where('is_default', true)->whereNull('couple_id');
    }

    public function scopeForCouple($query, int $coupleId)
    {
        return $query->where(function ($q) use ($coupleId) {
            $q->where('couple_id', $coupleId)->orWhere('is_default', true);
        });
    }
}
