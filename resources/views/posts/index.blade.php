@extends('layouts.app')

@section('title', 'Blog')

@section('content')

@forelse($posts as $key => $post)
{{--    @continue($key == 2)--}}
    @include('posts.partials.post')
@empty
    <h1>Not found</h1>
@endforelse

@endsection
