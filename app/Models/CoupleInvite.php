<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;
use Carbon\Carbon;

class CoupleInvite extends Model
{
    protected $fillable = [
        'inviter_id',
        'token',
        'expires_at',
        'status',
        'accepted_by',
        'accepted_at',
    ];

    protected $casts = [
        'expires_at'  => 'datetime',
        'accepted_at' => 'datetime',
    ];

    // ─── Relasi ───────────────────────────────────────────────────

    public function inviter(): BelongsTo
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }

    public function acceptedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'accepted_by');
    }

    // ─── Static Factory ───────────────────────────────────────────

    /**
     * Buat invite baru dengan token unik & expired 7 hari.
     */
    public static function createForUser(User $user): self
    {
        // Cancel semua invite pending milik user ini dulu
        static::where('inviter_id', $user->id)
              ->where('status', 'pending')
              ->update(['status' => 'cancelled']);

        return static::create([
            'inviter_id' => $user->id,
            'token'      => static::generateUniqueToken(),
            'expires_at' => Carbon::now()->addDays(7),
            'status'     => 'pending',
        ]);
    }

    /**
     * Generate token 8 karakter uppercase unik.
     */
    public static function generateUniqueToken(): string
    {
        do {
            // Format: XXXX-XXXX (lebih mudah dibaca)
            $token = strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));
        } while (static::where('token', $token)->exists());

        return $token;
    }

    // ─── Helper ───────────────────────────────────────────────────

    public function isValid(): bool
    {
        return $this->status === 'pending'
            && $this->expires_at->isFuture();
    }

    public function isExpired(): bool
    {
        return $this->expires_at->isPast();
    }

    /**
     * Sisa waktu dalam format manusiawi, e.g. "5 hari lagi".
     */
    public function getTimeRemainingAttribute(): string
    {
        if ($this->isExpired()) return 'Sudah kedaluwarsa';
        return $this->expires_at->diffForHumans(['parts' => 1], true) . ' lagi';
    }

    /**
     * URL invite yang bisa dibagikan.
     */
    public function getInviteUrlAttribute(): string
    {
        return route('couple.invite.accept', ['token' => $this->token]);
    }
}
