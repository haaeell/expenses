<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class GoalContribution extends Model
{
    use HasFactory;

    protected $fillable = [
        'goal_id','user_id','transaction_id',
        'amount','note','contributed_at'
    ];

    protected $casts = [
        'contributed_at' => 'date'
    ];

    public function goal()
    {
        return $this->belongsTo(Goal::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
