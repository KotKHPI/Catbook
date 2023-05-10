<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Jobs\NotifyUsersCatWasCommented;
use App\Mail\CommentPosted;
use App\Mail\CommentPostedMarkdown;
use App\Models\CatName;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CatCommentConrtoller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    public function store(CatName $cat, StoreComment $request)
    {
        $comment = $cat->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        Mail::to($cat->user)->send(
            new CommentPostedMarkdown($comment)
        );

        NotifyUsersCatWasCommented::dispatch($comment);

        return redirect()->back()
            ->withStatus('Comment was created!');
    }
}
