<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hire;
use App\Models\User;
use App\Models\Car;
use Carbon\Carbon;
use DB;

class HireController extends Controller
{
    public function index() {
        $hire=Hire::orderBy('id')->paginate(10);
        return view('hire.index')->with('hire',$hire);
    }
    
   

    public function store(Request $request)
    {
        //validate fields
        $attrs = $request->validate([
            'car_id' => 'required',
            'start'=>'required|date|date_format:Y-m-d',
            'end'=>'required|date|date_format:Y-m-d|after:start',
            //'days' => 'required',
            'amount' => 'string|required',
        ]);

        $isBooked = DB::table('hires')
        //->where('car_id', request('car_id'))
        ->where('car_id', $attrs['car_id'])
        ->whereDate('start', '<=', $attrs['start'])
        ->whereDate('end', '>=', $attrs['end'])
        ->exists();
        if($isBooked){
            //booking exists at selected time for the given car
            return response([
                'message' => 'Slot Not Available',
            ], 401);
        }
     
        else
        {
            $hire = Hire::create([
                'user_id' => auth()->user()->id,
                'car_id' => $attrs['car_id'],
                'start' =>$attrs['start'],
                'end' =>$attrs['end'],
                'amount' => $attrs['amount'],
                //'days' => $attrs['days'],
                //'image' => $image
            ]);
    
    
            return response([
                'message' => 'Hire created.',
                'hire' => $hire,
            ], 200); 
        }
        

       /* $hire = Hire::create([
            'user_id' => auth()->user()->id,
            'car_id' => $attrs['car_id'],
            'start' =>$attrs['start'],
            'end' =>$attrs['end'],
            'amount' => $attrs['amount'],
            //'days' => $attrs['days'],
            //'image' => $image
        ]);


        return response([
            'message' => 'Hire created.',
            'hire' => $hire,
        ], 200);*/
    }


    

    public function show($id){
        $hire = Hire::find($id);
        return view('hire.show')->with('hire',$hire);
    }

    public function edit($id)
    {
        $hire=Hire::find($id);
        return view('hire.edit')->with('hire',$hire);
    }

    public function destroy($id)
    {
        $hire=Hire::find($id);
        if($hire){
            $status=$order->delete();
            if($status){
                request()->session()->flash('success','Hire Successfully deleted');
            }
            else{
                request()->session()->flash('error','Hire can not deleted');
            }
            return redirect()->route('hire.index');
        }
        else{
            request()->session()->flash('error','Order can not found');
            return redirect()->back();
        }
    }

    public function view($id)
    {
        return response([
            'hire' => Hire::where('id', $id)->get()
        ],200);
    }

    // Income chart
    public function incomeChart(Request $request){
        $year=\Carbon\Carbon::now()->year;
        // dd($year);
        $hire=Hire::whereYear('created_at',$year)//->where('status','delivered')->get()
            ->groupBy(function($d){
                return \Carbon\Carbon::parse($d->created_at)->format('m');
            });
            // dd($items);
        $result=[];
        foreach($hire as $month=>$ihire){
            foreach($ihire as $hire){
                $amount=$hire->sum('amount');
                // dd($amount);
                $m=intval($month);
                // return $m;
                isset($result[$m]) ? $result[$m] += $amount :$result[$m]=$amount;
            }
        }
        $data=[];
        for($i=1; $i <=12; $i++){
            $monthName=date('F', mktime(0,0,0,$i,1));
            $data[$monthName] = (!empty($result[$i]))? number_format((float)($result[$i]), 2, '.', '') : 0.0;
        }
        return $data;
    }
}
