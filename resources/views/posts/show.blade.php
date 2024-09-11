@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>{{ $post->title }}</h1>
        <br>
        @if ($post->image)
            <img width="600" height="600" src="{{Storage::url($post->image->path)}}" alt="Post Image" class="img-fluid mb-3">
        @endif
        <div class="content">
            <blockquote class="blockquote">
                <p class="mb-0">{{$post->body}}</p>
                <footer class="blockquote-footer">By {{ $post->user->name }} on {{ $post->published_at }}</footer>
            </blockquote>
        </div>
        <h2>Categories:</h2>
        <ul>
            @foreach ($post->categories as $category)
                <li>{{ $category->name }}</li>
            @endforeach
        </ul>
        @if(session('success'))
            <div class="alert alert-success">
                <strong>Success!</strong> {{session('success')}}
                {{session('success')}}
            </div>
        @endif
        @include('comment.create', array('post_id' => $post->id))
        <br>
        @if(isset($comments))
            @include('comment.show', ['comments' => $comments])
        @endif

        <br>
        <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-3">Back to Posts</a>
    </div>
@endsection
