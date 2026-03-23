<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinancialScore extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_id',
        'score',
        'level',
        'breakdown',
        'recorded_date',
    ];

    protected function casts(): array
    {
        return [
            'score'         => 'integer',
            'breakdown'     => 'array',
            'recorded_date' => 'date',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────────

    public function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    /**
     * Map a raw score (0–100) to a human-readable level label.
     * Call this when recording a new score to auto-populate `level`.
     */
    public static function resolveLevel(int $score): string
    {
        return match (true) {
            $score >= 90 => 'Financial Goals',
            $score >= 75 => 'Money Power Couple',
            $score >= 60 => 'Saving Duo',
            $score >= 45 => 'Getting There',
            $score >= 30 => 'Work in Progress',
            default      => 'Broke Couple',
        };
    }

    // ── Scopes ─────────────────────────────────────────────────────────────

    public function scopeLatest($query)
    {
        return $query->orderByDesc('recorded_date');
    }

    public function scopeForYear($query, int $year)
    {
        return $query->whereYear('recorded_date', $year);
    }
}
