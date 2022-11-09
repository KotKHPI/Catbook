@extends('layouts.app')

@section('content')
    <form action="{{route('cats.store')}}" method="POST" >
        @csrf
        <label>Name:</label>
        <div><input type="text" name="name" value="{{old('title')}}"></div>
        <div> <textarea name="Age" value="{{old('content')}}"></textarea></div>
        <div><input type="submit" value="Create"></div>

        <br>
    </form>

@endsection
