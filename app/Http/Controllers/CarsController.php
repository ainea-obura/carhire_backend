<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

use App\Models\Car;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Image;

class CarsController extends Controller
{
    public function index(){
        $products = Car::getAllCar();
        return view('car.index',compact('products'));
    }

    public function create()
    {
        $products = Car::all();
        $brand=Brand::get();
        $category=Category::get();
        return view('car.create',compact('products'))->with('categories',$category)->with('brands',$brand);;
        //$brand=Brand::get();
        //$category=Category::where('is_parent',1)->get();
        // return $category;
        //return view('car.create')->with('categories',$category)->with('brands',$brand);

    }

    public function store(Request $req){
        $data = $req->validate([
            'title'=>'required',
            'cat_id'=>'required|exists:categories,id',
            'brand_id'=>'nullable|exists:brands,id',
            'price'=>'required',
            'summary'=>'string|required',
            'description'=>'string|nullable',
            'status'=>'required|in:active,inactive',
        ]);
        $slug=Str::slug($req->title);
        $count=Car::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        $new_product = Car::create($data);
        if($req->has('images')){
            foreach($req->file('images')as $image){
                $imageName = $data['title'].'-image-'.time().rand(1,1000).'.'.$image->extension();
                $image->move(public_path('product_images'),$imageName);
                Image::create([
                    'car_id'=>$new_product->id,
                    'image'=>$imageName
                ]);
            }
        }
        return back()->with('success','Added');
    }

    public function images($id){
        $product = Car::find($id);
        if(!$product) abort(404);
        $images = $product->images;
        return view('car.images',compact('product','images'));
    }
}
