@extends('layouts.app')

@section('title', 'cat')

@section('content')

 <div class="row">
     <div class="col-8">
         <h1>{{$cat->name}}</h1>

         @badge(['show' => now()->diffInMinutes($cat->created_at) < 25])
             Brand new Cat
         @endbadge

         <p>{{$cat->age}}</p>
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
