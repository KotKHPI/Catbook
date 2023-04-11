<div class="container">
    <div class="row">
        @card(['title' => 'Most Commented'])
        @slot('subtitle')
            What people are currently talking about
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
            Users with most has cats
        @endslot
        @slot('items', collect($mostActive)->pluck('name'))
        @endcard
    </div>

    <div class="row mt-4">
        @card(['title' => 'Most Active Last Month'])
        @slot('subtitle')
            Users with most has cats last month
        @endslot
        @slot('items', collect($mostActiveLastMonth)->pluck('name'))
        @endcard
    </div>
</div>
