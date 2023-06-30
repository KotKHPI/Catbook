@extends('layouts.app')

@section('title', 'Contact page')

@section('content')
    <h1>{{ __('Contact page') }}!</h1>

    @can('home.secret')
        <p>
            <a href="{{route('secret')}}">
                {{ __('Special information for admin users') }}
            </a>
        </p>
    @endcan
@endsection
