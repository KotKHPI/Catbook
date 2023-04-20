@extends('layouts.app')

@section('title', 'cat')

@section('content')

 <div class="row">
     <div class="col-8">

         @if($cat->image)
             <div style="background-image: url('{{ $cat->image->url() }}'); min-height: 500px; color: white; text-align: center; background-attachment: fixed;">
                <h1 style="padding-top: 100px; text-shadow: 1px 2px #000">
         @else
             <h1>
         @endif
         {{$cat->name}}
         @badge(['show' => now()->diffInMinutes($cat->created_at) < 25])
             Brand new Cat
         @endbadge
             </h1>
         @if($cat->image)
             </div>
         @endif

         <p>{{$cat->age}}</p>

{{--         <img src="{{ $cat->image->url() }}">--}}

         <p>Added {{$cat->created_at->diffForHumans()}}</p>

         @update(['date' => $cat->created_at, 'name' => $cat->user->name]) @endupdate

         @update(['date' => $cat->updated_at])
            Updated
         @endupdate

         <p>Currently read by {{ $counter }} people</p>

         @if((new \Carbon\Carbon())->diffInMinutes($cat->created_at) < 20)
             @badge(['type' => 'primary'])
                New!
             @endbadge
         @endif

         @tags(['tags' => $cat->tags]) @endtags

         <h4>Comments</h4>

         @include('comments._form')

         @forelse($cat->comments as $comment)
             <p>
                 {{ $comment->content }}
             </p>

             <p>
                 added {{\Carbon\Carbon::parse($comment['created_at'])->diffForHumans() }}
                 by {{$comment->user->name}}
             </p>

             @empty
                 <p>No comments yet!</p>
             @endforelse
     </div>

        <div class="col-4">
            @include('posts.partials.activity')
        </div>

 </div>

@endsection
