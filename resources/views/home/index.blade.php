@extends('layouts.app')

@section('title', 'Home page')

@section('content')
    <h1>{{ __('messages.welcome') }}</h1>
    <p>Okay, I am just trying now: {{ __('Just try to use json') }}</p>
@endsection
