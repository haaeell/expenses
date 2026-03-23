<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reminder extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_id','title','emoji','amount',
        'frequency','due_day','due_date','is_active'
    ];

    protected $casts = [
        'due_date' => 'date'
    ];

    public function couple()
    {
        return $this->belongsTo(Couple::class);
    }
}
