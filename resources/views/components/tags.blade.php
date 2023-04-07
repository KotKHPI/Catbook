<p>
    @if (is_array($tags) || is_object($tags))
        @foreach($tags as $tag)
            <a href="{{ route('cats.tags.index', ['tag' => $tag->id]) }}" class="badge badge-success badge-lg">{{ $tag->name }}</a>
        @endforeach
    @endif
</p>
