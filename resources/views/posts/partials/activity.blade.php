<div class="container">
    <div class="row">
        @card(['title' => 'Most Commented'])
        @slot('subtitle')
            {{ __('What people are currently talking about') }}
        @endslot
        @slot('items')
            @foreach($mostCommented as $post)
                <li class="list-group-item">
                    <a href="{{ route('cats.show', ['cat' => $post->id]) }}">
                        {{$post->name}}
                    </a>
                </li>
            @endforeach
        @endslot
        @endcard
    </div>

    <div class="row mt-4">
        @card(['title' => 'Most Active'])
        @slot('subtitle')
            {{ __('Writers with most cats') }}
        @endslot
        @slot('items', collect($mostActive)->pluck('name'))
        @endcard
    </div>

    <div class="row mt-4">
        @card(['title' => 'Most Active Last Month'])
        @slot('subtitle')
            {{ __('Users with most cats written in the month') }}
        @endslot
        @slot('items', collect($mostActiveLastMonth)->pluck('name'))
        @endcard
    </div>
</div>
