<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;
    //protected $fillable=['title','slug','summary','description','cat_id','child_cat_id','price','brand_id','discount','status','is_featured',];

    protected $guarded =[];
    public function images(){
        return $this->hasMany(Image::class);
    }

    public function cat_info(){
        return $this->hasOne('App\Models\Car','id','cat_id');
    }
    public function sub_cat_info(){
        return $this->hasOne('App\Models\Car','id','child_cat_id');
    }

    public static function getAllProduct(){
        return Car::with(['cat_info','sub_cat_info'])->orderBy('id','desc')->paginate(10);
    }

    public function rel_prods(){
        return $this->hasMany('App\Models\Product','cat_id','cat_id')->where('status','active')->orderBy('id','DESC')->limit(8);
    }
    public function getReview(){
        return $this->hasMany('App\Models\ProductReview','product_id','id')->with('user_info')->where('status','active')->orderBy('id','DESC');
    }
    public static function getProductBySlug($slug){
        return Car::with(['cat_info','rel_prods','getReview'])->where('slug',$slug)->first();
    }
    public static function countActiveProduct(){
        $data=Car::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }

    
    public function wishlists(){
        return $this->hasMany(Wishlist::class)->whereNotNull('cart_id');
    }

}
