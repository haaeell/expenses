<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReportsCache extends Model
{
    use HasFactory;

    protected $table = 'reports_cache';

    protected $fillable = [
        'couple_id',
        'type',
        'month',
        'year',
        'data',
        'generated_at',
    ];

    protected function casts(): array
    {
        return [
            'month'        => 'integer',
            'year'         => 'integer',
            'data'         => 'array',
            'generated_at' => 'datetime',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────────

    public function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────────

    public function scopeOfType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeForPeriod($query, int $year, ?int $month = null)
    {
        $query->where('year', $year);

        if ($month !== null) {
            $query->where('month', $month);
        }

        return $query;
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    /**
     * Fetch a cached report or regenerate it via the given callback.
     *
     * Usage:
     *   ReportsCache::remember($coupleId, 'monthly', $year, $month, function () { ... });
     */
    public static function remember(
        int $coupleId,
        string $type,
        int $year,
        ?int $month,
        callable $generator
    ): self {
        $record = static::where('couple_id', $coupleId)
            ->where('type', $type)
            ->where('year', $year)
            ->where('month', $month)
            ->first();

        if ($record) {
            return $record;
        }

        return static::create([
            'couple_id'    => $coupleId,
            'type'         => $type,
            'year'         => $year,
            'month'        => $month,
            'data'         => $generator(),
            'generated_at' => now(),
        ]);
    }
}
