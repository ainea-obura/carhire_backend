<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        $category=Category::getAllCategory();
        // return $category;
        return view('category.index')->with('categories',$category);

    }

    public function create()
    {
        $parent_cats=Category::get();
        return view('category.create')->with('parent_cats',$parent_cats);
    }

    public function store(Request $request)
    {
        // return $request->all();
        $this->validate($request,[
            'title'=>'string|required',
            'summary'=>'string|nullable',
            //'photo'=>'string|nullable',
            'status'=>'required|in:active,inactive',
        ]);
        $data= $request->all();
        $slug=Str::slug($request->title);
        $count=Category::where('slug',$slug)->count();
        if($count>0){
            $slug=$slug.'-'.date('ymdis').'-'.rand(0,999);
        }
        $data['slug']=$slug;  
        $status=Category::create($data);
        if($status){
            request()->session()->flash('success','Category successfully added');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('category.index');

    }

    public function edit($id)
    {
        //$parent_cats=Category::where('is_parent',1)->get();
        $category=Category::findOrFail($id);
        return view('category.edit')->with('category',$category);
    }

    public function update(Request $request, $id)
    {
        // return $request->all();
        $category=Category::findOrFail($id);
        $this->validate($request,[
            'title'=>'string|required',
            //'summary'=>'string|nullable',
            'status'=>'required|in:active,inactive',
        ]);
        $data= $request->all();
        $status=$category->fill($data)->save();
        if($status){
            request()->session()->flash('success','Category successfully updated');
        }
        else{
            request()->session()->flash('error','Error occurred, Please try again!');
        }
        return redirect()->route('category.index');
    }

    public function destroy($id)
    {
        $category=Category::findOrFail($id);
        $status=$category->delete();
        
        if($status){
            request()->session()->flash('success','Category successfully deleted');
        }
        else{
            request()->session()->flash('error','Error while deleting category');
        }
        return redirect()->route('category.index');
    }


}
