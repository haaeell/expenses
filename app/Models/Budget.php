<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'couple_id','category_id','limit_amount','month','year'
    ];

    public function couple()
    {
        return $this->belongsTo(Couple::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
