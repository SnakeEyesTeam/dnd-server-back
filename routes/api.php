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
    Route::get('/profile/followers', [FollowController::class, 'index']);
    Route::get('/profile/me', [ProfileController::class, 'view']);
    Route::get('/profile/{id}/my-follow', [FollowController::class, 'myFollow']);

    Route::get('/forum/{id}/my-like', [PostController::class, 'isLike']);

    Route::middleware('role:admin')->group(function () {
        Route::post('/profile/{id}/ban-action', [ProfileController::class, 'banAction']);
    });

    Route::middleware('is-banned')->group(function () {
        Route::post('/forum/{id}/comment/create', [ComentController::class, 'store']);
        Route::patch('/forum/{id}/comment/update', [ComentController::class, 'update']);
        Route::delete('/forum/{id}/comment/delete', [ComentController::class, 'destroy']);

        Route::post('/profile/{id}/follow', [FollowController::class, 'follow']);
        Route::post('/profile/update', [ProfileController::class, 'update']);

        Route::post('/forum/{id}/like-action', [PostController::class, 'likeAction']);
        Route::post('/forum/create/post', [PostController::class, 'store']);
        Route::delete('/forum/{id}/delete', [PostController::class, 'destroy']);
        Route::delete('/session/{id}', [SessionController::class, 'destroy']);

        Route::resource('/session', SessionController::class);
        Route::get('/session/{id}', [SessionController::class, 'show']);
        Route::post('/s/push-img', [SessionController::class, 'pushImg']);

        Route::resource('/session/map', MapController::class);
        Route::resource('/session/entity', EntityController::class);
        Route::resource('/session/object', ObjectController::class);
        Route::post('/profile/create/character', [CharacterController::class, 'store']);
        Route::delete('/profile/{id}/delete/character', [CharacterController::class, 'destroy']);

        Route::get('/s/maps', [MapController::class, 'index']);
        Route::get('/s/entities', [EntityController::class, 'index']);
        Route::get('/s/objects', [ObjectController::class, 'index']);
    });
});

Route::get('/forum/{id}/comments', [ComentController::class, 'show']);

Route::get('/profile/{id}/info', [ProfileController::class, 'index']);
Route::get('/profile/{id}/posts', [ProfileController::class, 'userPosts']);
Route::get('/profile/{id}/characters', [CharacterController::class, 'index']);
Route::get('/profile/{id}/sessions', [ProfileController::class, 'userSessions']);

Route::post('/template', function () {
    return 'template';
})->name('template');

Route::get('/profile/{id}/ban-reason', [ProfileController::class, 'banReason']);

Route::post('/profile/change-password', [ProfileController::class, 'changePassword']);
Route::post('/profile/reset-password', [ProfileController::class, 'resetPassword']);

Route::get('/users', [UserControler::class, "index"]);
Route::get('/users/search', [UserControler::class, "search"]);
Route::get('/users/from-array', [UserControler::class, "fromArray"]);

Route::get('/forum/{id}/department', [DepartamentController::class, "show"]);
Route::get('/forum/{id}/department/fixed', [DepartamentController::class, "fixed"]);
Route::get('/forum/departments', [DepartamentController::class, 'index']);
Route::get('/forum/{id}/post', [PostController::class, 'index']);

Route::post('/registration', [UserControler::class, 'store']);
Route::post('/auth', [UserControler::class, 'auth']);
Route::post('/logout', [UserControler::class, 'logout']);

Route::get('/server', function () {
    return true;
});
