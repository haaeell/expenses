<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SplitBill extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_id','paid_by','total_amount',
        'split_type','user1_amount','user2_amount',
        'description','emoji','is_settled',
        'settled_at','bill_date'
    ];

    protected $casts = [
        'settled_at' => 'datetime',
        'bill_date' => 'date'
    ];

    public function couple()
    {
        return $this->belongsTo(Couple::class);
    }

    public function payer()
    {
        return $this->belongsTo(User::class, 'paid_by');
    }
}
