<?php

namespace App\Http\Controllers\Api\V1;

use App\Events\CommentPosted;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreComment;
use App\Http\Resources\Comment as CommentResource;
use App\Models\CatName;
use App\Models\Comment;
use Illuminate\Http\Request;

class CatCommentController extends Controller
{

    public function __construct() {
        $this->middleware('auth:api')->only(['store', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(CatName $cat, Request $request)
    {
        $perPage = $request->input('per_page') ?? 8;
        return CommentResource::collection(
            $cat->comments()->with('user')->paginate($perPage)
                ->appends([
                'per_page' => $perPage
            ])
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return CommentResource
     */
    public function store(CatName $cat, StoreComment $request)
    {
        $comment = $cat->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);
        event(new CommentPosted($comment));

        return new CommentResource($comment);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return CommentResource
     */
    public function show(CatName $cat, Comment $comment)
    {
        return new CommentResource($comment);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return CommentResource
     */
    public function update(CatName $cat, Comment $comment, StoreComment $request)
    {
        $this->authorize($comment);
        $comment->content = $request->input('content');
        $comment->save();

        return new CommentResource($comment);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(CatName $cat, Comment $comment)
    {
        $this->authorize($comment);
        $comment->delete();

        return response()->noContent();
    }
}
