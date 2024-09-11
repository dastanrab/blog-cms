@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Category</h1>
        @if(isset($success))
            <div class="alert alert-success">
                <strong>Success!</strong> {{$success}}
            </div>
        @endif
        <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Category Name</label>
                <input type="text" name="name" id="title" class="form-control" value="{{ old('name') }}" required>
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
            </div>


            <button type="submit" class="btn btn-primary mt-2">Create Category</button>
        </form>
    </div>
@endsection
