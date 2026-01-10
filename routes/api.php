<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\DepartamentController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\FollowController;
use App\Http\Controllers\MapController;
use App\Http\Controllers\ObjectController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserControler;
use App\Http\Controllers\ComentController;


Route::middleware('auth:sanctum')->group(function () {
    Route::middleware('role:admin')->group(function () {
        Route::post('/profile/{id}/ban-action', [ProfileController::class, 'ban']);
        Route::resource('/session/map', EntityController::class);
    });
    Route::middleware('is-banned')->group(function () {
        Route::resource('/map', MapController::class);
        
        Route::resource('/forum/comment', ComentController::class);
        
        Route::get('/profile/{id}/info', [ProfileController::class, 'index']);
        Route::get('/profile/{id}/post', [ProfileController::class, 'show']);
        Route::get('/profile/{id}/characters', [CharacterController::class, 'getCharacter']);
        Route::get('/profile/followers', [FollowController::class, 'index']);
        Route::get('/profile/me', [ProfileController::class, 'view']);
        Route::post('/profile/{id}/follow', [FollowController::class, 'follow']);
        Route::post('/profile/update', [UserControler::class, 'update_user']);
        
        Route::post('/forum/{id}/like-action', [PostController::class, 'like']);
        Route::post('/forum/create/post', [PostController::class, 'store']);
        Route::get('/forum/{id}/delete', [PostController::class, 'destroy']);
        
        Route::resource('/session', SessionController::class);
        Route::resource('/session/entity', EntityController::class);
        Route::resource('/session/object', ObjectController::class);
    });
    Route::get('/profile/{id}/ban-reason', [ProfileController::class, 'banReason']);
});
Route::post('/template', function () {
    return 'template';
})->name('template');
Route::post('/profile/change-password', [ProfileController::class, 'change_password']);
Route::post('/profile/reset-password', [ProfileController::class, 'reset_password']);

Route::get('/users', [UserControler::class, "index"]);
Route::get(' /forum/{id}/deparmnent', [DepartamentController::class ,"show"]);

Route::get('/forum/departaments', [DepartamentController::class, 'index']);
Route::get('/forum/{id}/post', [PostController::class, 'index']);

Route::post('/registration', [UserControler::class, 'store']);
Route::post('/auth', [UserControler::class, 'auth']);
Route::post('/logout', [UserControler::class, 'logout']);

Route::get('/server', function () {
    return 'ok';
});

$response = Http::withoutVerifying()->get('https://aternia.games/url/sLKZc4');

