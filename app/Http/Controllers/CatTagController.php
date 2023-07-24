<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class CatTagController extends Controller
{
    public function index($tag)
    {
        $tag = Tag::findOrFail($tag);

        return view('home.cat',
            [
                'cats' => $tag->catName()
                    ->latestWithRelations()
                    ->get(),
            ]);

    }
}
