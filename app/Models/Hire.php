<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Hire extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'pickup_date',
        'pickup_time',
        'dropoff_date',
        'dropoff_time',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}
