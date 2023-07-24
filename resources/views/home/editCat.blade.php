@extends('layouts.app')

@section('title', 'catCreat')

@section('content')
    <form action="{{route('cats.update', ['cat' => $cat->id])}}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('posts.partials.form')
        <div><input type="submit" class="btn btn-primary btn-block" value="Edit"></div>
    </form>


@endsection
