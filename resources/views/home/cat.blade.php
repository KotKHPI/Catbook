@extends('layouts.app')

@section('title', 'cat')

@section('content')

    <style>
        .link {
            @apply font-medium text-gray-700 underline decoration-pink-500
        }
    </style>

    <div class="row">
        <div class="col-8">
            @forelse($cats as $cat)
                @if($cat->trashed())
                    <del>
                @endif
                <a class="{{$cat->trashed() ? 'text-muted' : ''}}"
                    href="{{route('cats.show', ['cat' => $cat->id])}}">{{$cat['name']}}
                </a>

                @if($cat->trashed())
                    </del>
                @endif

                <p>{{$cat['age']}} years old</p>

                @tags(['tags' => $cat->tags]) @endtags

{{--                <p class="text-muted">--}}
{{--                    Added {{\Carbon\Carbon::parse($cat['created_at'])->diffForHumans() }}--}}
{{--                    by {{$cat->user->name}}--}}
{{--                </p>--}}

                @update(['date' => $cat->created_at, 'name' => $cat->user->name, 'userId' => $cat->user->id])
                @endupdate

                <p>{{ trans_choice('messages.comments', $cat->comments_count) }}</p>

                <div class="mb-3">

                    @auth
                        @can('update', $cat)
                            <a href="{{route('cats.edit', ['cat' => $cat->id])}}" class="btn btn-primary">Edit</a>
                        @endcan
                    @endauth

{{--                    @cannot('delete', $cat)--}}
{{--                        <p>You can't delete this cat!!!</p>--}}
{{--                    @endcannot--}}

                    @if(!$cat->trashed())
                        @auth
                            @can('delete', $cat)
                                <form class="d-inline" action="{{route('cats.destroy', ['cat' => $cat->id])}}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <input type="submit" value="Delete" class="btn btn-primary">
                                </form>
                            @endcan
                        @endauth
                    @endif
                </div>
{{--            <x-tags :tags="$cat->tags" />--}}
            @empty
                <div>{{ __('Where are my cats?') }}</div>
            @endforelse
        </div>

        <div class="col-4">
            @include('posts.partials.activity')
        </div>
    </div>

    @if($cats->count())
        <nav>
            {{ $cats->links() }}
        </nav>
    @endif

@endsection
