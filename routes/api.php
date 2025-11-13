<?php

use App\Http\Controllers\DeportamentController;
use App\Http\Controllers\PostController;
use App\Models\deportament;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControler;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('statusU')->group(function () {
        
        Route::middleware('role:admin')->group(function () {
            Route::post('ban-user-{id}', [UserControler::class, 'ban']);
            Route::post('/makeDep', [DeportamentController::class, 'makeDep']);
        });

        Route::post('/logout', [UserControler::class, 'logout']);

        Route::post('/makePost', [PostController::class, 'makePost']);
        Route::post('/update/{id}', [UserControler::class, 'update_file']);
    });

});

Route::post('/store', [UserControler::class, 'store']);
Route::post('/posts', [PostController::class, 'index']);
Route::post('/login', [UserControler::class, 'auth']);