@forelse($comments as $comment)
    <p>
        {{ $comment->content }}
    </p>

    <p>
        @update(['date' => $comment->created_at, 'name' => $comment->user->name, 'userId' => $comment->user->id])
        @endupdate
    </p>

@empty
    <p>No comments yet!</p>
@endforelse
