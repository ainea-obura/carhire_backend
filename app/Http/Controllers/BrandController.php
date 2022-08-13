<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\Brand;


class BrandController extends Controller
{
    public function index()
    {
        $brand=Brand::orderBy('id','DESC')->paginate();
        return view('brand.index')->with('brands',$brand);
    }

    public function create()
    {
        return view('brand.create');
    }

    public function store(Request $request)
    {
        $this->validate($request,[
            'title'=>'string|required',
            //'file' => 'mimes:jpeg,bmp,png'
        ]);
         // When we have a file we will parse it
        
        $data=$request->all();
        $fileName = time().$request->file('logo')->getClientOriginalName();
        $path = $request->file('logo')->storeAs('logo', $fileName, 'public');
        $data["logo"] = '/storage/'.$path;
        
        
        $slug=Str::slug($request->title);
        $count=Brand::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;
        // return $data;
        $status=Brand::create($data);
        if($status){
            request()->session()->flash('success','Brand successfully created');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('brand.index');
    }

    public function display()
    {
        //return Brand::all();
        return response([
            'brands' => Brand::orderBy('created_at', 'desc')->get()
        ],200);
    }

    public function show($id)
    {
        //return Brand::find($id);
        return response([
            'brand' => Brand::where('id', $id)->get()
        ],200);
    }

    public function edit($id)
    {
        $brand=Brand::find($id);
        if(!$brand){
            request()->session()->flash('error','Brand not found');
        }
        return view('brand.edit')->with('brand',$brand);
    }

    public function update(Request $request, $id)
    {
        $brand=Brand::find($id);
        $this->validate($request,[
            'title'=>'string|required',
        ]);
        $data=$request->all();
       
        $status=$brand->fill($data)->save();
        if($status){
            request()->session()->flash('success','Brand successfully updated');
        }
        else{
            request()->session()->flash('error','Error, Please try again');
        }
        return redirect()->route('brand.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $brand=Brand::find($id);
        if($brand){
            $status=$brand->delete();
            if($status){
                request()->session()->flash('success','Brand successfully deleted');
            }
            else{
                request()->session()->flash('error','Error, Please try again');
            }
            return redirect()->route('brand.index');
        }
        else{
            request()->session()->flash('error','Brand not found');
            return redirect()->back();
        }
    }
}
