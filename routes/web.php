<?php

use App\Http\Controllers\UserControler;
use Illuminate\Support\Facades\Route;



Route::get('/', function () {
    return view('welcome');
});