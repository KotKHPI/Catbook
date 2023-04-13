<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreComment;
use App\Models\CatName;
use Illuminate\Http\Request;

class CatCommentConrtoller extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only('store');
    }

    public function store(CatName $cat, StoreComment $request)
    {
        $cat->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);

        $request->session()->flash('status', 'Comment was created!');

        return redirect()->back();
    }
}
