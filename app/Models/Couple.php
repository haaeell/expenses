<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Couple extends Model {
  protected $fillable = [
    'user1_id','user2_id','couple_name',
    'anniversary_date','privacy_mode','health_score'
  ];
  protected function casts(): array {
    return ['anniversary_date' => 'date'];
  }

  public function user1() { return $this->belongsTo(User::class, 'user1_id'); }
  public function user2() { return $this->belongsTo(User::class, 'user2_id'); }
  public function wallets() { return $this->hasMany(Wallet::class); }
  public function transactions() { return $this->hasMany(Transaction::class); }
  public function goals() { return $this->hasMany(Goal::class); }
  public function splitBills() { return $this->hasMany(SplitBill::class); }
  public function budgets() { return $this->hasMany(Budget::class); }
  public function reminders() { return $this->hasMany(Reminder::class); }
  public function badges() { return $this->belongsToMany(Badge::class, 'couple_badges')->withPivot('earned_at'); }
  public function categories() { return $this->hasMany(Category::class); }

  // Helper: dapatkan partner dari user tertentu
  public function partnerOf($userId): ?User {
    return $this->user1_id == $userId ? $this->user2 : $this->user1;
  }

  // Helper: total saldo hutang antar pasangan
  public function debtBalance(): array {
    $unsettled = $this->splitBills()->where('is_settled', false)->get();
    $debt = [$this->user1_id => 0, $this->user2_id => 0];
    foreach ($unsettled as $bill) {
      $other = $bill->paid_by == $this->user1_id ? $this->user2_id : $this->user1_id;
      $owedAmount = $bill->paid_by == $this->user1_id ? $bill->user2_amount : $bill->user1_amount;
      $debt[$other] += $owedAmount;
    }
    return $debt;
  }
}
