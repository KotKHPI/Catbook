@extends('layouts.app')

@section('title', 'Contact page')

@section('content')
    <h1>Content Page!</h1>

    @can('home.secret')
        <p>
            <a href="{{route('secret')}}">
                Special information for admin users
            </a>
        </p>
    @endcan
@endsection
