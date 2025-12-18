<?php

use App\Http\Controllers\DeportamentController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\MapsController;
use App\Http\Controllers\PostController;
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

            Route::resource('/entity',EntityController::class);
        });

        Route::resource('/maps',MapsController::class);

        Route::post('/logout', [UserControler::class, 'logout']);
        Route::post('/change-password',[UserControler::class,'change_password']);

        Route::post('/forum/create/post', [PostController::class, 'makePost']);
        Route::post('/update/{id}', [UserControler::class, 'update_user']);
    });

});

Route::get('forum/deportaments',[DeportamentController::class,'index']);
Route::get('forum/{id}/post',[PostController::class,'index']);

Route::post('/registration', [UserControler::class, 'store']);
Route::post('/auth', [UserControler::class, 'auth']);