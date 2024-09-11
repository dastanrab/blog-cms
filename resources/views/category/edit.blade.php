@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Post</h1>
        @if(session('success'))
            <div class="alert alert-success">
                <strong>Success!</strong> {{session('success')}}
            </div>
        @endif
        <form action="{{ route('categories.update', $category) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Category</label>
                <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $category->name) }}" required>
                @error('name')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image"  class="form-control @error('image') is-invalid @enderror">
                @error('image')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                @if ($category->image)
                    <p>Current Image: <img src="{{Storage::url($category->image->path)}}" alt="Post Image" width="100" height="100"></p>
                @endif
            </div>

            <button type="submit" class="btn btn-primary mt-2">Update Category</button>
        </form>
    </div>
@endsection
