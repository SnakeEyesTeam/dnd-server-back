<?php

use App\Http\Controllers\DepartamentController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControler;


Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::post('/profile/ban-action/{id}', [ProfileController::class, 'ban']);
        Route::post('/makeDep', [DepartamentController::class, 'makeDep']);

        Route::resource('/entity', EntityController::class);

        Route::get('/forum/{id}/delete', [PostController::class, 'destroy']);
    });
    Route::middleware('is_banned')->group(function () {
        Route::resource('/maps', MapController::class);

        Route::post('/change-password', [UserControler::class, 'change_password']);
        Route::get('/profile/{id}/info', [ProfileController::class, 'info']);
        Route::get('/profile/{id}/post', [ProfileController::class, 'post']);
        
        Route::post('/forum/create/post', [PostController::class, 'makePost']);
        Route::get('/forum/{id}/delete', [PostController::class, 'destroy']);
        
        Route::post('/update/{id}', [UserControler::class, 'update_user']);
    });
});

Route::get('forum/deportaments', [DepartamentController::class, 'index']);
Route::get('forum/{id}/post', [PostController::class, 'index']);

Route::post('/registration', [UserControler::class, 'store']);
Route::post('/auth', [UserControler::class, 'auth']);
Route::post('/logout', [UserControler::class, 'logout']);