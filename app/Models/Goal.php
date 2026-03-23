<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Goal extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_id','created_by','name','emoji','photo_url',
        'description','target_amount','current_amount',
        'deadline','type','user1_ratio','user2_ratio',
        'status','milestones'
    ];

    protected $casts = [
        'deadline' => 'date',
        'milestones' => 'array'
    ];

    public function couple()
    {
        return $this->belongsTo(Couple::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function contributions()
    {
        return $this->hasMany(GoalContribution::class);
    }
}
