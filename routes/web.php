<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('login', function () {
    return response()->json(['message' => 'Unauthorised'], 403);
})->name('login');
