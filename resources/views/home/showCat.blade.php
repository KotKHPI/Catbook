@extends('layouts.app')

@section('title', 'cat')

@section('content')


        <h1>{{$cat->name}}</h1>

        @badge(['show' => now()->diffInMinutes($cat->created_at) < 25])
            Brand new Cat
        @endbadge

        <p>{{$cat->age}}</p>

        <p>Added {{$cat->created_at->diffForHumans()}}</p>

        @update(['date' => $cat->created_at, 'name' => $cat->user->name])
        @endupdate

        @update(['date' => $cat->updated_at])
        Updated
        @endupdate

    @if((new \Carbon\Carbon())->diffInMinutes($cat->created_at) < 20)
        @badge(['type' => 'primary'])
            New!
        @endbadge
    @endif

        <h4>Comments</h4>
    @forelse($cat->comments as $comment)
        <p>
            {{ $comment->content }}
        </p>
        <p>
            added {{\Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }}
        </p>
    @empty
        <p>No comments yet!</p>
    @endforelse


@endsection
