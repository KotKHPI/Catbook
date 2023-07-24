<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Jobs\NotifyUsersCatWasCommented;
use App\Events\CommentPosted;
use App\Mail\CommentPostedMarkdown;
use App\Models\CatName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Http\Resources\Comment as CommentResource;

class CatCommentConrtoller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    public function index(CatName $cat) {
//        return $cat->comments()->with('user')->get();
//        return new CommentResource($cat->comments()->first());
        return CommentResource::collection($cat->comments);
    }

    public function store(CatName $cat, StoreComment $request)
    {
        $comment = $cat->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        event(new CommentPosted($comment));
//        Mail::to($cat->user)->send(
//            new CommentPostedMarkdown($comment)
//        );
//
//        NotifyUsersCatWasCommented::dispatch($comment);

        return redirect()->back()
            ->withStatus('Comment was created!');
    }
}
