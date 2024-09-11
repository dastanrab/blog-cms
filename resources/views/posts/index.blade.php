@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Posts</h1>
        @can('create', App\Models\Post::class)
            <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Create New Post</a>
        @endcan
        <form method="GET" action="{{ route('posts.index') }}">
            <div class="row mb-4">
                <div class="col-md-4">
                    <input type="text" name="title" class="form-control" placeholder="Search by title" value="{{ request('title') }}">
                </div>
                <div class="col-md-4">
                    <select name="category" class="form-control" >
                        <option value="">Filter by categories</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ $category->id == request('category') ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <button type="submit" class="btn btn-warning">Search</button>
                </div>
            </div>
        </form>
        @if ($posts->count())
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publish Status</th>
                    <th>Published At</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td>{{ $post->title }}</td>
                        <td>{{ $post->user->name }}</td>
                        <td>{{$post->publish_status}}</td>
                        <td>{{ $post->published_at }}</td>
                        <td>
                            @if($post->publish_status == 'Published')
                                <a href="{{ route('posts.show', $post) }}" class="btn btn-info btn-sm">View</a>
                            @endif
                            @can('update', $post)
                                <a href="{{ route('posts.edit', $post) }}" class="btn btn-warning btn-sm">Edit</a>
                            @endcan
                            @can('delete', $post)
                                <form action="{{ route('posts.destroy', $post) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $posts->links() }}
        @else
            <p>No posts found.</p>
        @endif
    </div>
@endsection
