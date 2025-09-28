<?php

use App\Http\Controllers\UserControler;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::post('/store', [UserControler::class, 'store']);
Route::post('/auth', [UserControler::class, 'auth']);