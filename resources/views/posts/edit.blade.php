@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Post</h1>
        @if(session('success'))
            <div class="alert alert-success">
                <strong>Success!</strong> {{session('success')}}
            </div>
        @endif
        <form action="{{ route('posts.update', $post) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" class="form-control" value="{{ old('title', $post->title) }}" required>
                @error('title')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="content">Content</label>
                <textarea name="body" id="body" class="form-control @error('body') is-invalid @enderror" rows="5"  >{{ $post->body }}</textarea>
                @error('body')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image"  class="form-control @error('image') is-invalid @enderror">
                @error('image')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
                @if ($post->image)
                    <p>Current Image: <img src="{{Storage::url($post->image->path)}}" alt="Post Image" width="100" height="100"></p>
                @endif
            </div>

            <div class="form-group">
                <label for="categories">Categories</label>
                <select name="categories[]" id="categories" class="form-control @error('categories') is-invalid @enderror"  multiple>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ in_array($category->id, $post->categories->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('categories')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="categories">Publish Status</label>
                <select name="publish_status" id="publish_status" class="form-control @error('publish_status') is-invalid @enderror" >
                    @foreach (config('app.publish_statuses',[]) as $status)
                        <option value="{{ $status }}" {{ $status==$post->publish_status ? 'selected' : '' }}>{{ $status }}</option>
                    @endforeach
                </select>
                @error('publish_status')
                <span class="invalid-feedback" role="alert">{{ $message }}</span>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-2">Update Post</button>
        </form>
    </div>
@endsection
