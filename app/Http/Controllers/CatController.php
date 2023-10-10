<?php

namespace App\Http\Controllers;

use App\Contracts\CounterContract;
use App\Events\CatPosted;
use App\Facades\CounterFacade;
use App\Http\Requests\CatPost;
use App\Models\CatName;
use App\Models\Comment;
use App\Models\Image;
use App\Models\User;
use App\Services\Counter;
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

    private $counter;

    public function __construct()
    {
        $this->middleware('auth')->only('create', 'edit', 'destroy');
    }

    public function index()
    {

        return view('home.cat',
            [
                'cats' => CatName::latestWithRelations()->paginate(10)
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
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
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

        event(new CatPosted($cat));

        $request->session()->flash('status', 'New cat!');

        return redirect()->route('cats.show', ['cat' => $cat->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\Response
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

        return view('home.showCat', [
            'cat' => $catName,
            'counter' => CounterFacade::increment("cat-name{$id}", ['cat-name'])
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


