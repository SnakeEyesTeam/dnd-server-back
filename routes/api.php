<?php

use App\Http\Controllers\CharactersController;
use App\Http\Controllers\DepartamentController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControler;
use App\Http\Controllers\ComentController;


Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::post('/profile/ban-action/{id}', [ProfileController::class, 'ban']);
        Route::post('/makeDep', [DepartamentController::class, 'makeDep']);

        Route::resource('/entity', EntityController::class);
    });
    Route::middleware('is_banned')->group(function () {
        Route::resource('/maps', MapController::class);

        Route::resource('/forum/comment', ComentController::class);

        Route::get('/profile/{id}/info', [ProfileController::class, 'info']);
        Route::get('/profile/{id}/post', [ProfileController::class, 'post']);
        Route::get('/profile/{id}/characters', [CharactersController::class, 'getCharacter']);
        Route::post('/profile/subscribe/{id}', [FollowController::class, 'Follow']);
        Route::post('/profile/update/{id}', [UserControler::class, 'update_user']);
        
        Route::post('/forum/{id}/like-action', [PostController::class, 'like']);
        Route::post('/forum/create/post', [PostController::class, 'makePost']);
        Route::get('/forum/{id}/delete', [PostController::class, 'destroy']);
        
        Route::post('/template', function () {
            return 'template';
        })->name('template');
    });
    Route::get('/profile/{id}/ban-reason', [ProfileController::class, 'banReason']);
});
Route::post('/profile/change-password', [ProfileController::class, 'change_password']);
Route::post('/profile/reset-password', [ProfileController::class, 'sendResetLink']);

Route::get('/users', [UserControler::class, "getUser"]);
Route::get('/forum/deparmnent/{id}', [DepartamentController::class, "getDepartament"]);

Route::get('/forum/departaments', [DepartamentController::class, 'index']);
Route::get('/forum/{id}/post', [PostController::class, 'index']);

Route::post('/registration', [UserControler::class, 'store']);
Route::post('/auth', [UserControler::class, 'auth']);
Route::post('/logout', [UserControler::class, 'logout']);

Route::get('/server', function () {
    return 'ok';
});