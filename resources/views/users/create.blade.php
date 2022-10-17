@extends('layouts.master')

@section('content')

<div class="card">
    <h5 class="card-header">Add User</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.store')}}">
        {{csrf_field()}}
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">fname</label>
        <input id="inputTitle" type="text" name="fname" placeholder="First name"  value="{{old('fname')}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>
        
        <div class="form-group">
        <label for="inputTitle" class="col-form-label">lname</label>
        <input id="inputTitle" type="text" name="lname" placeholder="Last name"  value="{{old('lname')}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
        <label for="inputTitle" class="col-form-label">phone</label>
        <input id="inputTitle" type="text" name="phone" placeholder="Phone number"  value="{{old('phone')}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
            <label for="inputEmail" class="col-form-label">Email</label>
          <input id="inputEmail" type="email" name="email" placeholder="Enter email"  value="{{old('email')}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="inputPassword" class="col-form-label">Password</label>
          <input id="inputPassword" type="password" name="password" placeholder="Enter password"  value="{{old('password')}}" class="form-control">
          @error('password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="confirmPassword" class="col-form-label">Password</label>
          <input id="confirmPassword" type="password" name="confirmpassword" placeholder="Cofirm password"  value="{{old('password')}}" class="form-control">
          @error('confirmpassword')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        @php 
        $roles=DB::table('users')->select('role')->get();
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
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>
          <div class="form-group">
            <label for="status" class="col-form-label">Status</label>
            <select name="status" class="form-control">
                <option value="active">Active</option>
                <option value="inactive">Inactive</option>
            </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
          </div>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush