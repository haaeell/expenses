<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class CoupleBadge extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'couple_id','badge_id','earned_at'
    ];

    protected $casts = [
        'earned_at' => 'datetime'
    ];

    public function couple()
    {
        return $this->belongsTo(Couple::class);
    }

    public function badge()
    {
        return $this->belongsTo(Badge::class);
    }
}
