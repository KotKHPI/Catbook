<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\Api\V1\CatCommentController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->name('api.v1.')->group(function() {
    Route::get('/status', function () {
        return response()->json(['status' => 'OK']);
    })->name('status');

    Route::apiResource('cats.comment', CatCommentController::class);
});

    Route::fallback(function () {
        return response()->json([
            'message' => 'Not found'
        ], 404);
    })->name('api.fallback');

