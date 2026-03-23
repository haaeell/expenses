<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'emoji',
        'type',
        'criteria',
        'reward_points',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'criteria'      => 'array',
            'reward_points' => 'integer',
            'is_active'     => 'boolean',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────────

    public function coupleMissions(): HasMany
    {
        return $this->hasMany(CoupleMission::class);
    }

    // ── Scopes ─────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
