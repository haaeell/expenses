<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Couple extends Model
{
    use HasFactory;

    protected $fillable = [
        'user1_id',
        'user2_id',
        'couple_name',
        'anniversary_date',
        'privacy_mode',
        'health_score',
    ];

    protected function casts(): array
    {
        return [
            'anniversary_date' => 'date',
            'health_score'     => 'integer',
        ];
    }

    // ── Relationships ──────────────────────────────────────────────────────

    public function user1(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user1_id');
    }

    public function user2(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user2_id');
    }

    public function invites(): HasMany
    {
        return $this->hasMany(CoupleInvite::class, 'inviter_id', 'user1_id');
    }

    public function wallets(): HasMany
    {
        return $this->hasMany(Wallet::class);
    }

    public function categories(): HasMany
    {
        return $this->hasMany(Category::class);
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
        return $this->hasMany(Goal::class);
    }

    public function splitBillEvents(): HasMany
    {
        return $this->hasMany(SplitBillEvent::class);
    }

    public function splitBills(): HasMany
    {
        return $this->hasMany(SplitBill::class);
    }

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function missions(): HasMany
    {
        return $this->hasMany(CoupleMission::class);
    }

    public function reminders(): HasMany
    {
        return $this->hasMany(Reminder::class);
    }

    public function badges(): HasMany
    {
        return $this->hasMany(CoupleBadge::class);
    }

    public function financialScores(): HasMany
    {
        return $this->hasMany(FinancialScore::class);
    }

    public function notifications(): HasMany
    {
        return $this->hasMany(Notification::class);
    }

    public function calendarSyncs(): HasMany
    {
        return $this->hasMany(CalendarSync::class);
    }

    public function reportsCache(): HasMany
    {
        return $this->hasMany(ReportsCache::class);
    }

    // ── Helpers ────────────────────────────────────────────────────────────

    /** Returns both users as a collection */
    public function members(): \Illuminate\Support\Collection
    {
        return collect([$this->user1, $this->user2])->filter();
    }
}
