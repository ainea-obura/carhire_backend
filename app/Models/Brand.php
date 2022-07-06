<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;
    protected $fillable=['title','slug','status'];

    public function cars(){
        return $this->hasMany('App\Models\Car','brand_id','id')->where('status','active');
    }
    public static function getCarsByBrand($slug){
        // dd($slug);
        return Brand::with('cars')->where('slug',$slug)->first();
        // return Car::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
}
