<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'nickname',
        'avatar',
        'color_hex',
        'birth_date',
        'gender',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'birth_date' => 'date',
            'password' => 'hashed',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────────

    /** Couple where this user is user1 */
    public function coupleAsUser1(): HasOne
    {
        return $this->hasOne(Couple::class, 'user1_id');
    }

    /** Couple where this user is user2 */
    public function coupleAsUser2(): HasOne
    {
        return $this->hasOne(Couple::class, 'user2_id');
    }

    /** Convenience: returns the couple regardless of slot */
   public function getCoupleAttribute(): ?Couple
    {
        return $this->coupleAsUser1 ?? $this->coupleAsUser2;
    }

    public function loadCouple()
    {
        return $this->load([
            'coupleAsUser1.user1',
            'coupleAsUser1.user2',
            'coupleAsUser2.user1',
            'coupleAsUser2.user2',
        ]);
    }

    public function coupleInvites(): HasMany
    {
        return $this->hasMany(CoupleInvite::class, 'inviter_id');
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function recurringTransactions(): HasMany
    {
        return $this->hasMany(RecurringTransaction::class);
    }

    public function goals(): HasMany
    {
        return $this->hasMany(Goal::class, 'created_by');
    }

    public function goalContributions(): HasMany
    {
        return $this->hasMany(GoalContribution::class);
    }

    public function splitBillsPaid(): HasMany
    {
        return $this->hasMany(SplitBill::class, 'paid_by');
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function calendarSyncs(): HasMany
    {
        return $this->hasMany(CalendarSync::class);
    }
}
