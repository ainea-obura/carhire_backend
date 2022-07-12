@extends('layouts.master')

@section('content')
    @if (session('success'))
        <div class="alert alert-dismissible alert-success">
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            <h4 class="alert-heading">Success!</h4>
            <p class="mb-0">New car was added successfully!</p>
        </div>
    @endif
    <div class="card">
        <h3 classs="card-header">Add a Car</h3>
        <div class="card-body">
            <div class="col-md-5">
                <form action="{{ route('car.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label for="title" class="mt-4">Car Title:</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror " name="title"
                            placeholder="Enter car title">
                        <span class="text-danger">
                            @error('title')
                                {{ $message }}
                            @enderror
                        </span>

                    </div>
                    <div class="form-group">
                        <label for="price" class="mt-4">Car Price:</label>
                        <input type="number" step="any" min="1"
                            class="form-control @error('price') is-invalid @enderror " name="price"
                            placeholder="Enter product price">
                        <span class="text-danger">
                            @error('price')
                                {{ $message }}
                            @enderror
                        </span>

                    </div>
                    <div class="form-group">
                        <label for="files" class="form-label mt-4">Upload Car Images:</label>
                        <input type="file" name="images[]" class="form-control" accept="image/*" multiple>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Save Car</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
