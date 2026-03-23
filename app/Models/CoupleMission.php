<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoupleMission extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_id',
        'mission_id',
        'status',
        'progress',
        'started_at',
        'completed_at',
        'deadline_at',
    ];

    protected function casts(): array
    {
        return [
            'progress'     => 'integer',
            'started_at'   => 'datetime',
            'completed_at' => 'datetime',
            'deadline_at'  => 'datetime',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────────

    public function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }

    public function mission(): BelongsTo
    {
        return $this->belongsTo(Mission::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }
}
