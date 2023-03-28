<?php

namespace App\Http\Controllers;

use App\Http\Requests\CatPost;
use App\Models\CatName;
use App\Models\Comment;
use App\Models\User;
use Illuminate\Auth\Access\Gate;
use Illuminate\Http\Request;

class CatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home.cat',
            ['cats' => CatName::latest()->withCount('comments')->get(),
                'mostCommented' => CatName::mostCommented()->take(5)->get(),
                'mostActive' => User::withMostCatNames()->take(5)->get()
            ]
        );
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
        $cat->save();

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

        return view('home.showCat', [
            'cat' => CatName::with('comments')->findOrFail($id)
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
        $valideted = $request->validated();
        $cat->fill($valideted);
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


