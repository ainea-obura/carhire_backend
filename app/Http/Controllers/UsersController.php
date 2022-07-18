<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        $users=User::orderBy('id','ASC')->paginate(10);
        return view('users.index')->with('users',$users);
    }

    public function create()
    {
        return view('users.create');
    }
    public function store(Request $request)
    {
        $this->validate($request,
        [
            'fname' => 'required|string',
            'lname' => 'required|string',
            'phone' => 'required|unique:users',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'=>'required|in:admin,user',
        ]);
        // dd($request->all());
        $data=$request->all();
        $data['password']=Hash::make($request->password);
        // dd($data);
        $status=User::create($data);
        // dd($status);
        if($status){
            request()->session()->flash('success','Successfully added user');
        }
        else{
            request()->session()->flash('error','Error occurred while adding user');
        }
        return redirect()->route('users.index');

    }

    public function edit($id)
    {
        $user=User::findOrFail($id);
        return view('users.edit')->with('user',$user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user=User::findOrFail($id);
        $this->validate($request,
        [
            'fname' => 'required|string',
            'lname' => 'required|string',
            'phone' => 'required|unique:users',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:8|confirmed',
            'role'=>'required|in:admin,user',
        ]);
        // dd($request->all());
        $data=$request->all();
        // dd($data);
        
        $status=$user->fill($data)->save();
        if($status){
            request()->session()->flash('success','Successfully updated');
        }
        else{
            request()->session()->flash('error','Error occured while updating');
        }
        return redirect()->route('users.index');

    }

    public function destroy($id)
    {
        $delete=User::findorFail($id);
        $status=$delete->delete();
        if($status){
            request()->session()->flash('success','User Successfully deleted');
        }
        else{
            request()->session()->flash('error','There is an error while deleting users');
        }
        return redirect()->route('users.index');
    }
}
