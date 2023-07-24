@component('mail::message')
# Comment was posted on cat you're watching

Hi {{ $user->name }}

Someone has commented on your cat

@component('mail::button', ['url' => route('cats.show', [$comment->commentable->id])])
    View the cat
@endcomponent

@component('mail::button', ['url' => route('cats.show', [$comment->user->id])])
    Visit {{ $comment->user->name }} profile
@endcomponent

@component('mail::panel')
    {{ $comment->content }}
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
