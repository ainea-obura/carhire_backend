<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hire;
use App\Models\User;

class HireController extends Controller
{
    public function index() {

    }
    
    public function store(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'start'=>'required|date|date_format:Y-m-d',
            'end'=>'required|date|date_format:Y-m-d',
            //'days' => 'required',
            //'total_amnt' => 'string|required'
        ]);

        //$image = $this->saveImage($request->image, 'posts');

        $hire = Hire::create([
            //'user_id' => auth()->user()->id,
            'start' =>$attrs['start'],
            'end' =>$attrs['end'],
            //'days' => $attrs['days'],
            //'total_amnt' => $attrs['total_amnt']
            //'image' => $image
        ]);


        return response([
            'message' => 'Hire created.',
            'hire' => $hire,
        ], 200);
    }
}
