<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CoupleInvite extends Model
{
    use HasFactory;

    protected $fillable = [
        'inviter_id','token','status','expires_at'
    ];

    protected $casts = [
        'expires_at' => 'datetime'
    ];

    public function inviter()
    {
        return $this->belongsTo(User::class, 'inviter_id');
    }
}
