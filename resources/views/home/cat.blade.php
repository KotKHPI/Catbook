@extends('layouts.app')

@section('title', 'cat')

@section('content')

    @if(isset($cat))
    <div>Where are my cats?</div>
    @endif

    @foreach($cats as $cat)
        <a href="{{route('cats.show', ['cat' => $cat->id])}}">{{$cat['name']}}</a>
        <p>{{$cat['age']}}</p>

        @if($cat->comments_count)
            <p>{{$cat->comments_count}} comments</p>
        @else
            <p>No comments yet!</p>
        @endif

        <div class="mb-3">
            <a href="{{route('cats.edit', ['cat' => $cat->id])}}" class="btn btn-primary">Edit</a>
            <form class="d-inline" action="{{route('cats.destroy', ['cat' => $cat->id])}}" method="POST">
                @csrf
                @method('DELETE')
                <input type="submit" value="Delete" class="btn btn-primary">
            </form>
        </div>
    @endforeach

@endsection
