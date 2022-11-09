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
        'car_id',
        'start',
        'end',
        //'days',
        'amount',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public static function countActiveHire(){
        $data=Hire::count();
        if($data){
            return $data;
        }
        return 0;
    }

    //public function checkDate()
    
}
