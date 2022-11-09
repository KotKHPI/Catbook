@extends('layouts.app')

@section('title', 'cat')

@section('content')


        <h1>{{$cat->name}}</h1>
        <p>{{$cat->age}}</p>
<p>Added {{$cat->created_at->diffForHumans()}}</p>

    @if(now()->diffInMinutes($cat->created_at) < 5)
<div class="alert alert-info">New!</div>
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
