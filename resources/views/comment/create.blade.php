<div class="container">
    <h3>Add Comment</h3>
    <form action="{{ route('comments.store') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="post_id" value="{{$post_id}}">
        @csrf
        <div class="form-group">
            <textarea name="text" id="text" class="form-control @error('text') is-invalid @enderror" rows="5"  >{{ old('text') }}</textarea>
            @error('text')
            <span class="invalid-feedback" role="alert">{{ $message }}</span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-sm mt-2">Add Comment</button>
    </form>
</div>
