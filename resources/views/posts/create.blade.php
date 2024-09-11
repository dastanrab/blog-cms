@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create New Post</h1>
        @if(isset($success))
            <div class="alert alert-success">
                <strong>Success!</strong> {{$success}}
            </div>
        @endif
        @if(isset($fail))
            <div class="alert alert-danger">
                <strong>fail!</strong> {{$fail}}
            </div>
        @endif
        <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
                @error('title')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="body">Body</label>
                <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror" rows="5"  >{{ old('body') }}</textarea>
                @error('body')
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

            <div class="form-group">
                <label for="categories">Categories</label>
                <select name="categories[]" id="categories" class="form-control @error('categories') is-invalid @enderror" multiple>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach

                </select>
                @error('categories')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-2">Create Post</button>
        </form>
        <br>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Back to Posts</a>
    </div>
@endsection
