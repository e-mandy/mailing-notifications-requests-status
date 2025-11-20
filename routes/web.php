<?php

use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;


Route::get('/login', function(){
    return view('auth.login')->name('login');
});

Route::get('/register', function(){
    return view('auth.register')->name('register');
});

Route::post('/register', [AuthController::class, 'register'])->name('register');

Route::group([
    'middleware' => 'auth'
], function(){
    Route::get('/home', function() {
        return view('home');
    })->name('home');
});