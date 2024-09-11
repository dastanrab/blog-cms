@extends('layouts.app')

@section('content')
    <div class="container">

        <h1>{{ $category->name }}</h1>
        <br>
        @if ($category->image)
            <img width="600" height="600" src="{{Storage::url($category->image->path)}}" alt="Post Image" class="img-fluid mb-3">
        @endif

        <br>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">Back to Categories</a>
    </div>
@endsection
