<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model {
  use SoftDeletes;

  protected $fillable = [
    'couple_id','user_id','wallet_id','category_id',
    'type','amount','description','mood',
    'receipt_photo','tags','is_recurring',
    'recurring_freq','transaction_date'
  ];
  protected function casts(): array {
    return [
      'tags'             => 'array',
      'transaction_date' => 'date',
      'is_recurring'    => 'boolean',
      'amount'           => 'decimal:2',
    ];
  }

  public function user()     { return $this->belongsTo(User::class); }
  public function couple()  { return $this->belongsTo(Couple::class); }
  public function category(){ return $this->belongsTo(Category::class); }
  public function wallet()  { return $this->belongsTo(Wallet::class); }

  // Scope by type
  public function scopeIncome($q)  { return $q->where('type','income'); }
  public function scopeExpense($q) { return $q->where('type','expense'); }
  public function scopeThisMonth($q) {
    return $q->whereMonth('transaction_date', now()->month)
              ->whereYear('transaction_date', now()->year);
  }

  // Accessor: format Rupiah
  public function getFormattedAmountAttribute(): string {
    return 'Rp ' . number_format($this->amount, 0, ',', '.');
  }

  public function getMoodEmojiAttribute(): string {
    return match($this->mood) {
      'happy'   => '😊',
      'stress'  => '😤',
      'fomo'    => '😱',
      'hungry'  => '🍜',
      'guilty'  => '😅',
      default   => '😐',
    };
  }
}
