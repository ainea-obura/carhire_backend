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
            <div class="col-md-12">
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
                        <label for="cat_id">Category <span class="text-danger">*</span></label>
                        <select name="cat_id" id="cat_id" class="form-control">
                            <option value="">--Select any category--</option>
                            @foreach ($categories as $key => $cat_data)
                                <option value='{{ $cat_data->id }}'>{{ $cat_data->title }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="brand_id">Brand</label>
                        {{-- {{$brands}} --}}
    
                        <select name="brand_id" class="form-control">
                            <option value="">--Select Brand--</option>
                            @foreach ($brands as $brand)
                                <option value="{{ $brand->id }}">{{ $brand->title }}</option>
                            @endforeach
                        </select>
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

                    <div class="form-group">
                        <label for="year" class="col-form-label">Y.O.M <span class="text-danger">*</span></label>
                        <textarea class="form-control" id="year" name="year">{{ old('year') }}</textarea>
                        @error('year')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>
    
                    <div class="form-group">
                        <label for="seats" class="col-form-label">Seats</label>
                        <textarea class="form-control" id="seats" name="seats">{{ old('seats') }}</textarea>
                        @error('seats')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
                        <select name="status" class="form-control">
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                        @error('status')
                            <span class="text-danger">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group">
                        <label for="files" class="form-label mt-4">Upload thumbnail:</label>
                        <input class="form-control" name="thumbnail" type="file" id="thumbnail">
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Save Car</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('admin/summernote/summernote.min.css') }}">
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.css" />
@endpush
@push('scripts')
    <script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
    <script src="{{ asset('admin/summernote/summernote.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>

    <script>
        $('#lfm').filemanager('image');

        $(document).ready(function() {
            $('#summary').summernote({
                placeholder: "Write short seats.....",
                tabsize: 2,
                height: 100
            });
        });

        $(document).ready(function() {
            $('#seats').summernote({
                placeholder: "Write detail seats.....",
                tabsize: 2,
                height: 150
            });
        });
        // $('select').selectpicker();
    </script>

    
@endpush