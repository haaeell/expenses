<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

// ============================================================
//  GoalMilestone
// ============================================================
class GoalMilestone extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id',
        'name',
        'target_amount',
        'order',
        'is_reached',
        'reached_at',
    ];

    protected function casts(): array
    {
        return [
            'target_amount' => 'decimal:2',
            'order'         => 'integer',
            'is_reached'    => 'boolean',
            'reached_at'    => 'datetime',
        ];
    }

    public function goal(): BelongsTo
    {
        return $this->belongsTo(Goal::class);
    }
}
