@extends('layouts.app')

@section('tiitle', $post['title'])

@section('content')
    @if($post['is_new'])
        <div>Hey, if works</div>
    @elseif(!$post['is_new'])
        <div>Elseif works too</div>
    @endif

    @unless($post['check_unless'])
        <h2>Something with unless</h2>
    @endunless

    @isset($post['check_unless'])
        <h3>USE ISSET</h3>
    @endisset

<h1>{{ $post['title'] }}</h1>
<p>{{ $post['content'] }}</p>

@endsection
