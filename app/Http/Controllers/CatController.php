<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatPost;
use App\Models\CatName;
use App\Models\Comment;
use App\Models\Image;
use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class CatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth')->only('create', 'edit', 'destroy');
    }

    public function index()
    {

        return view('home.cat',
            [
                'cats' => CatName::latestWithRelations()->get()
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('home.createCat');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CatPost $request)
    {
        $validete = $request->validated();
        $validete['user_id'] = $request->user()->id;
        $cat = CatName::create($validete);

        if($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnail');
            $cat->image()->save(
                Image::make(['path' => $path])
            );
        }

        $request->session()->flash('status', 'New cat!');

        return redirect()->route('cats.show', ['cat' => $cat->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
//        return view('home.showCat', [
//            'cat' => CatName::with(['comments' => function($query) {
//                return $query->latest();
//            }])->findOrFail($id)
//        ]);   One of variant using Local Query

        $catName = Cache::tags(['cat-name'])->remember("cat-name-{$id}", 60, function () use($id) {
            return CatName::with('comments', 'tags', 'user', 'comments.user')->findOrFail($id);
        });

        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";

        $users = Cache::tags(['cat-name'])->get($usersKey, []);
        $usersUpdate = [];
        $diffrence = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= 1) {
                $diffrence--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if(
            !array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId]) >= 1
        ) {
            $diffrence++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::forever($usersKey, $usersUpdate);

        if (!Cache::tags(['cat-name'])->has($counterKey)) {
            Cache::tags(['cat-name'])->forever($counterKey, 1);
        } else {
            Cache::tags(['cat-name'])->increment($counterKey, $diffrence);
        }

        $counter = Cache::tags(['cat-name'])->get($counterKey);

        return view('home.showCat', [
            'cat' => $catName,
            'counter' => $counter
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cat = CatName::findOrFail($id);
//        if(\Illuminate\Support\Facades\Gate::denies('update-cat', $cat)) {
//            abort(403);
//        }
        $this->authorize($cat);

        return view('home.editCat', ['cat' => $cat]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(CatPost $request, $id)
    {
        $cat = CatName::findOrFail($id);
        $this->authorize($cat);
        $valideted = $request->validated();
        $cat->fill($valideted);

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnail');

            if($cat->image) {
                Storage::delete($cat->image->path);
                $cat->image->path = $path;
                $cat->image->save();
            } else {
                $cat->image()->save(
                    Image::make(['path' => $path])
                );
            }
        }

        $cat->save();

        $request->session()->flash('status', 'Cat was update!');

        return redirect()->route('cats.show', ['cat' => $cat->id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cat = CatName::findOrFail($id);

        $this->authorize($cat);

        $cat->delete();

        session()->flash('status', 'Cat ' . $cat['name'] . ' was lost(');

        return redirect()->route('cats.index');
    }
}


