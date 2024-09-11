<div class="container">
    @if ($comments->isEmpty())
        <p>No comments yet.</p>
    @else
        <ul class="list-group">
            @foreach ($comments as $comment)
                <li class="list-group-item">
                    <p>{{ $comment->text }}</p>
                    <span class="text-muted">{{ $comment->created_at->diffForHumans() }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
