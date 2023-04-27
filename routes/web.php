<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\CatTagController;
use App\Http\Controllers\UserController;
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
Route::get('/secret', [HomeController::class, 'secret'])->name('secret');

Route::resource('cats', \App\Http\Controllers\CatController::class);
Route::resource('users', UserController::class)->only(['show', 'edit', 'update']);

Route::get('/cats/tag/{tag}', [CatTagController::class, 'index'])->name('cats.tags.index');
Route::resource('cats.comment', \App\Http\Controllers\CatCommentConrtoller::class)->only('store');
Route::resource('users.comments', \App\Http\Controllers\UserCommentController::class)->only('store');

Auth::routes();
