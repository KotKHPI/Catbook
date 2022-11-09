@extends('layouts.app')

@section('title', 'catCreat')

@section('content')
    <form action="{{route('cats.store')}}" method="POST">
        @csrf
        @include('posts.partials.form')
        <div><input type="submit" value="Create" class="btn btn-primary btn-block"></div>
    </form>


@endsection
