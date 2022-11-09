<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'home'])->name('home');
Route::get('/contact', [HomeController::class, 'contact'])->name('contact');


Route::resource('posts', PostController::class)->only('index', 'show', 'create', 'store');

Route::resource('cats', \App\Http\Controllers\CatController::class);
//Route::get('/post', function () use($posts) {
////    dd(request()->input('age', '10'));
//    return view('posts.index', ['posts' => $posts]);
//});
//
//Route::get('/posts/{id}', function ($id) use($posts) {
//   abort_if(!isset($posts[$id]), 404);
//return view('posts.show', ['post'=>$posts[$id]]);
//})->name('posts');

//Route::prefix('/fun')->name('fun.')->group(function() use($posts) {
//
//Route::get('responses', function () use($posts) {
//    return response($posts, 201)->header('Type', 'app.json')->cookie('MY_COOKIE', 'meow-meow');
//});
//
//Route::get('redirect', function () {
//   return redirect('/contact');
//})->name('redirect');
//Route::get('redirect2', function () {
//    return redirect()->route('posts', $id = 1);
//})->name('redirect2');
//Route::get('back', function () {
//    return back();
//})->name('back');
//Route::get('away', function () {
//    return redirect()->away('https://google.com');
//})->name('away');
//
//Route::get('download', function () {
//    return response()->download(public_path('/photo_2022-06-28 15.47.04.jpeg'), 'cat.jpeg');
//})->name('download');
//});\

//Route::get('/cats/{id}', function ($id) {
//   $cats = [
//   1 => ['name' => 'Batman',
//       'age' => 11],
//   2 => ['name' => 'Bonya',
//       'age' => 2]
//   ];
//   abort_if(!isset($cats[$id]), 404);
//   return view('home.cat', ['cat' => $cats[$id]]);
//});
