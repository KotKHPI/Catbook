@extends('layouts.app')

@section('title', 'cat')

@section('content')

    @if(isset($cat))
    <div>Where are my cats?</div>
    @endif

    <div class="row">
        <div class="col-8">
    @foreach($cats as $cat)
        <a href="{{route('cats.show', ['cat' => $cat->id])}}">{{$cat['name']}}</a>
        <p>{{$cat['age']}}</p>

        <p class="text-muted">
            Added {{\Carbon\Carbon::parse($cat['created_at'])->diffForHumans() }}
            by {{$cat->user->name}}
        </p>

        @if($cat->comments_count)
            <p>{{$cat->comments_count}} comments</p>
        @else
            <p>No comments yet!</p>
        @endif

        <div class="mb-3">
            @can('update', $cat)
            <a href="{{route('cats.edit', ['cat' => $cat->id])}}" class="btn btn-primary">Edit</a>
            @endcan

            @cannot('delete', $cat)
                <p>You can't delete this cat!!!</p>
            @endcannot

            @can('delete', $cat)
            <form class="d-inline" action="{{route('cats.destroy', ['cat' => $cat->id])}}" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" value="Delete" class="btn btn-primary">
            </form>
                @endcan
        </div>
    @endforeach
        </div>
{{--    <div class="col-4">--}}
{{--        <div class="card" style="width: 18rem;">--}}
{{--            <div class="card-body">--}}
{{--                <h5 class="card-title">Most Commented</h5>--}}
{{--                <h6 class="card-subtitle mb-2 text-muted">--}}
{{--                    What people are currently talking about--}}
{{--                </h6>--}}
{{--            </div>--}}
{{--            <ul class="list-group list-group-flush">--}}
{{--                @foreach($mostCommented as $post)--}}
{{--                    <li class="list-group-item">--}}
{{--                        <a href="{{ route('cats.show', ['cat' => $post->id]) }}">--}}
{{--                            {{$post->name}}--}}
{{--                        </a>--}}
{{--                    </li>--}}
{{--                @endforeach--}}
{{--            </ul>--}}
{{--        </div>--}}
{{--    </div>--}}
        <div class="col-4">
            <div class="container">
                <div class="row">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Commented</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                What people are currently talking about
                            </h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach($mostCommented as $post)
                                <li class="list-group-item">
                                    <a href="{{ route('cats.show', ['cat' => $post->id]) }}">
                                        {{$post->name}}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>

                <div class="row mt-4">
                    <div class="card" style="width: 100%;">
                        <div class="card-body">
                            <h5 class="card-title">Most Active</h5>
                            <h6 class="card-subtitle mb-2 text-muted">
                                Users with most has cats
                            </h6>
                        </div>
                        <ul class="list-group list-group-flush">
                            @foreach ($mostActive as $user)
                                <li class="list-group-item">
                                    {{ $user->name }}
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
