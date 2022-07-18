@extends('layouts.master')

@section('content')
    <div class="card">
        <h5 class="card-header">Edit User</h5>
        <div class="card-body">
            <form method="post" action="{{ route('users.update', $user->id) }}">
                @csrf
                @method('PATCH')
                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">First Name</label>
                    <input id="inputTitle" type="text" name="fname" placeholder="First name" value="{{ $user->fname }}"
                        class="form-control">
                    @error('fname')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Last Name</label>
                    <input id="inputTitle" type="text" name="lname" placeholder="Last name"
                        value="{{ $user->lname }}" class="form-control">
                    @error('lname')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputTitle" class="col-form-label">Phone</label>
                    <input id="inputTitle" type="text" name="phone" placeholder="Phone number"
                        value="{{ $user->phone }}" class="form-control">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="inputEmail" class="col-form-label">Email</label>
                    <input id="inputEmail" type="email" name="email" placeholder="Enter email"
                        value="{{ $user->email }}" class="form-control">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                {{-- <div class="form-group">
            <label for="inputPassword" class="col-form-label">Password</label>
          <input id="inputPassword" type="password" name="password" placeholder="Enter password"  value="{{$user->password}}" class="form-control">
          @error('password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div> --}}

                @php
                    $roles = DB::table('users')
                        ->select('role')
                        ->where('id', $user->id)
                        ->get();
                    // dd($roles);
                @endphp
                <div class="form-group">
                    <label for="role" class="col-form-label">Role</label>
                    <select name="role" class="form-control">
                        <option value="">-----Select Role-----</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->role }}" {{ $role->role == 'admin' ? 'selected' : '' }}>Admin
                            </option>
                            <option value="{{ $role->role }}" {{ $role->role == 'user' ? 'selected' : '' }}>User
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="status" class="col-form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="active" {{ $user->status == 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ $user->status == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group mb-3">
                    <button class="btn btn-success" type="submit">Update</button>
                </div>
            </form>
        </div>
    </div>
@endsection


