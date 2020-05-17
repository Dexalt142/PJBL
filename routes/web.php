<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::middleware('guest')->group(function() {
    Route::get('/', function () {
        return view('login');
    });

    Route::get('register', function() {
        return view('register');
    })->name('register');

    Route::get('login', function() {
        return view('login');
    })->name('login');

    Route::post('login', 'Auth\LoginController@login');
    Route::post('register', 'Auth\RegisterController@register');
});

Route::middleware('auth')->group(function() {
    Route::get('home', function() {
        return view('logout');
    });

    Route::post('logout', 'Auth\LoginController@logout');
});

Route::middleware('guru')->group(function() {
    Route::get('guru', function() {
        echo "Test";
    });
});


