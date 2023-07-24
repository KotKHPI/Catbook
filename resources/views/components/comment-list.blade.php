@forelse($comments as $comment)
    <p>
        {{ $comment->content }}
    </p>
    @tags(['tags' => $comment->tags])@endtags
    @update(['date' => $comment->created_at, 'name' => $comment->user->name, 'userId' => $comment->user->id])
    @endupdate
@empty
    <p>{{ __('messages.comments') }}!</p>
@endforelse
