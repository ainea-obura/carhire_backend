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
            'year'=>'numeric|required',
            'seats'=>'numeric|nullable',
            'status'=>'required|in:active,inactive',
        ]);
        $slug=Str::slug($req->title);
        $count=Car::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        if($req->hasfile('thumbnail'))
        {
            $fileName = time().$req->file('thumbnail')->getClientOriginalName();
            $path = $req->file('thumbnail')->storeAs('thumbnail', $fileName, 'public');
            $data["thumbnail"] = '/storage/'.$path;

        }

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
        //return back()->with('success','Added');
        return redirect()->route('car.index');
    }

    public function images($id){
        $product = Car::find($id);
        if(!$product) abort(404);
        $images = $product->images;
        return view('car.images',compact('product','images'));
    }

    public function display(){
        //return Car::all()->with('images');
        
        return response([
            'cars' => Car::orderBy('created_at', 'desc')->with('images')->get()
        ],200);
    }

    public function show($id)
    {
        //return Car::find($id);
        return response([
            'car' => Car::where('id', $id)->with('images')->get()
        ],200);
    }

    public function edit($id)
    {
        $brand=Brand::get();
        $product=Car::findOrFail($id);
        $category=Category::get();
        $items=Car::where('id',$id)->get();
        // return $items;
        return view('car.edit')->with('product',$product)
                    ->with('brands',$brand)
                    ->with('categories',$category)->with('items',$items);
    }

    public function update(Request $request, $id)
    {
        $product=Car::findOrFail($id);
        $this->validate($request,[
            'title'=>'required',
            'cat_id'=>'required|exists:categories,id',
            'brand_id'=>'nullable|exists:brands,id',
            'price'=>'required',
            'year'=>'numeric|required',
            'seats'=>'numeric|nullable',
            'status'=>'required|in:active,inactive',
        ]);

        $data=$request->all();
        return $data;
        $status=$product->fill($data)->save();
        if($status){
            request()->session()->flash('success','Product Successfully updated');
        }
        else{
            request()->session()->flash('error','Please try again!!');
        }
        return redirect()->route('car.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Car::findOrFail($id);
        $status=$product->delete();
        
        if($status){
            request()->session()->flash('success','Product successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting product');
        }
        return redirect()->route('car.index');
    }

}
