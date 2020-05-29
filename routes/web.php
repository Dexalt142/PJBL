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
    })->name('root');

    Route::get('register', function() {
        return view('register');
    })->name('register');

    Route::get('login', function() {
        return view('login');
    })->name('login');

    Route::post('login', 'Auth\LoginController@login')->name('login-post');
    Route::post('register', 'Auth\RegisterController@register')->name('register-post');
});

Route::middleware('auth')->group(function() {
    Route::get('profile-setup', 'Auth\ProfileController@showSetupPage')->name('profile-setup');
    Route::post('profile-setup', 'Auth\ProfileController@setupProfile');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
});


Route::middleware('guru', 'user-validated')->group(function() {
    Route::get('guru', 'GuruPageController@showDashboard')->name('guru-dashboard');
    
    Route::prefix('guru')->group(function() {
        Route::prefix('kelas')->group(function() {
            Route::get('{kelas}', 'GuruPageController@viewKelas')->name('guru-kelas-detail');

            Route::post('buat', 'KelasController@buatKelas')->name('guru-kelas-create');
            Route::post('{kelas}/undang', 'KelasController@undangSiswa')->name('guru-kelas-invite');
            Route::post('{kelas}/edit', 'KelasController@editKelas')->name('guru-kelas-edit');
            Route::post('{kelas}/gencode', 'KelasController@generateNewCode')->name('guru-kelas-gencode');
        });
        
        Route::prefix('project')->group(function() {
            Route::get('/', 'ProjectController@showProjectPage')->name('guru-project');
            Route::get('{id_project}', 'ProjectController@viewProject')->name('guru-project-detail');

            Route::post('buat', 'ProjectController@buatProject')->name('guru-project-create');
            Route::post('{id_project}/genkel', 'ProjectController@generateKelompok')->name('guru-kelompok-generate');
        });


    });
});

Route::middleware('siswa', 'user-validated')->group(function() {
    Route::get('siswa', function() {
        return view('siswa.dashboard');
    })->name('siswa-dashboard');

    Route::prefix('siswa')->group(function() {
        Route::prefix('kelas')->group(function() {
            Route::get('{kelas}', 'SiswaPageController@viewKelas')->name('siswa-kelas-detail');
            Route::post('gabung', 'KelasController@gabungKelas');
        });

        Route::prefix('project')->group(function() {
            Route::get('{id_project}', 'SiswaPageController@viewProject')->name('siswa-project-detail');
        });

    });
});