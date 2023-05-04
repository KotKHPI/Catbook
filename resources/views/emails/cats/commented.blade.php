<style>
    body {
        font-family: Arial, Helvetica, sans-serif;
    }
</style>

<p>Hi {{ $comment->commentable->user->name }}</p>

<p>
    Someone has commented on your cat
    <a href="{{ route('cats.show', ['cat' => $comment->commentable->id]) }}">
        {{ $comment->commentable->name }}
    </a>
</p>

<hr/>

<p>
    <a href="{{ route('users.show', ['user' => $comment->user->id]) }}">
        {{ $comment->user->name }}
    </a> said:
</p>

<p>
    "{{ $comment->content }}"
</p>
