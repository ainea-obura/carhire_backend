<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hire;
use App\Models\User;

class HireController extends Controller
{
    // create a post
    public function store(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'pickup_date'=>'required|date|date_format:Y-m-d',
            'pickup_time'=>'required|date_format:"H:i"',
            'dropoff_date'=>'required|date|date_format:Y-m-d',
            'dropoff_time'=>'required|date_format:"H:i"',
        ]);

        //$image = $this->saveImage($request->image, 'posts');

        $hire = Hire::create([
            'user_id' => auth()->user()->id,
            'pickup_date' =>$attrs['pickup_date'],
            'pickup_time' =>$attrs['pickup_time'],
            'dropoff_date' =>$attrs['dropoff_date'],
            'dropoff_time' =>$attrs['dropoff_time'],
            //'image' => $image
        ]);


        return response([
            'message' => 'Hire created.',
            'hire' => $hire,
        ], 200);
    }
}
