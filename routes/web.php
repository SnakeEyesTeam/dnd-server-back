<?php

use App\Http\Controllers\UserControler;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::post('/store', [UserControler::class, 'store']);
Route::post('/auth', [UserControler::class, 'auth']);
Route::post('/logout', [UserControler::class, 'logout']);
Route::post('/login', [UserControler::class, 'auth']);
Route::post('/update/{id}', [UserControler::class, 'update_file']);