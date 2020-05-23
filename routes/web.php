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
    Route::get('profile-setup', 'Auth\ProfileController@showSetupPage')->name('profile-setup');
    Route::post('profile-setup', 'Auth\ProfileController@setupProfile');
    Route::post('logout', 'Auth\LoginController@logout');
});


Route::middleware('guru', 'user-validated')->group(function() {
    Route::get('guru', 'GuruPageController@showDashboard')->name('guru-dashboard');

    Route::prefix('guru')->group(function() {
        Route::prefix('kelas')->group(function() {
            Route::post('buat', 'KelasController@buatKelas');
            Route::get('{kelas}', 'GuruPageController@viewKelas')->name('guru-kelas-detail');
            Route::post('edit/{kelas}', 'KelasController@editKelas');
            
            Route::post('gencode/{kelas}', 'KelasController@generateNewCode');
        });

        Route::prefix('project')->group(function() {
            Route::get('/', 'ProjectController@showProjectPage')->name('guru-project');
            Route::get('{id_project}', 'ProjectController@viewProject')->name('guru-project-detail');
            Route::post('buat', 'ProjectController@buatProject');
        });

    });
});

Route::middleware('siswa', 'user-validated')->group(function() {
    Route::get('siswa', function() {
        return view('siswa.dashboard');
    })->name('siswa-dashboard');
});


