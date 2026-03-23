<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_id',
        'created_by',
        'name',
        'emoji',
        'photo_url',
        'description',
        'target_amount',
        'current_amount',
        'deadline',
        'type',
        'user1_ratio',
        'user2_ratio',
        'status',
        'milestones',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'target_amount'  => 'decimal:2',
            'current_amount' => 'decimal:2',
            'deadline'       => 'date',
            'user1_ratio'    => 'integer',
            'user2_ratio'    => 'integer',
            'milestones'     => 'array',
            'completed_at'   => 'datetime',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────────

    public function couple(): BelongsTo
    {
        return $this->belongsTo(Couple::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function milestoneRecords(): HasMany
    {
        return $this->hasMany(GoalMilestone::class)->orderBy('order');
    }

    public function contributions(): HasMany
    {
        return $this->hasMany(GoalContribution::class);
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    public function progressPercentage(): float
    {
        if ($this->target_amount <= 0) return 0;
        return min(100, round(($this->current_amount / $this->target_amount) * 100, 2));
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    // ── Scopes ─────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
