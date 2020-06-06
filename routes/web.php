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
    Route::post('profile-setup', 'Auth\ProfileController@setupProfile')->name('profile-setup-post');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
});

Route::middleware('guru', 'user-validated')->group(function() {
    Route::get('guru', 'GuruPageController@showDashboard')->name('guru-dashboard');
    
    Route::prefix('guru')->group(function() {
        Route::get('project', 'ProjectController@showProjectPage')->name('guru-project');
        Route::prefix('kelas')->group(function() {
            Route::get('/', 'KelasController@showKelasPage')->name('guru-kelas');
            Route::post('buat', 'KelasController@buatKelas')->name('guru-kelas-create');
            
            Route::prefix('{kelas}')->group(function() {
                Route::get('/', 'GuruPageController@viewKelas')->name('guru-kelas-detail');

                Route::post('undang', 'KelasController@undangSiswa')->name('guru-kelas-invite');
                Route::post('edit', 'KelasController@editKelas')->name('guru-kelas-edit');
                Route::post('gencode', 'KelasController@generateNewCode')->name('guru-kelas-gencode');
    
    
                Route::get('{project}', 'ProjectController@viewProject')->name('guru-project-detail');
                
                Route::post('{project}/fase/buat', 'ProjectController@buatFase')->name('guru-fase-create');
                Route::post('project/buat', 'ProjectController@buatProject')->name('guru-project-create');
                Route::post('{project}/genkel', 'ProjectController@generateKelompok')->name('guru-kelompok-generate');
    
                Route::prefix('{project}')->group(function() {
                    Route::get('{fase}', 'ProjectController@viewFase')->name('guru-fase-detail');
                    Route::post('{fase}/edit', 'ProjectController@editFase')->name('guru-fase-edit');
                    Route::post('{fase}/nilai', 'ProjectController@nilaiFase')->name('guru-fase-nilai');
                    Route::post('tambah-anggota', 'ProjectController@tambahAnggota')->name('guru-anggota-tambah');
                    Route::post('hapus-anggota', 'ProjectController@hapusAnggota')->name('guru-anggota-hapus');
                });
            });

        });

    });

    Route::prefix('api')->group(function() {
        Route::post('fase/detail', 'APIController@faseDetail')->name('api-fase-detail');
        Route::post('anggota', 'APIController@getAnggotaKelompok')->name('api-anggota');
    });
});

Route::middleware('siswa', 'user-validated')->group(function() {
    Route::get('siswa', function() {
        return view('siswa.dashboard');
    })->name('siswa-dashboard');

    Route::prefix('siswa')->group(function() {
        Route::prefix('kelas')->group(function() {
            Route::get('{kelas}', 'SiswaPageController@viewKelas')->name('siswa-kelas-detail');
            Route::post('gabung', 'KelasController@gabungKelas')->name('siswa-kelas-join');

            Route::prefix('{kelas}')->group(function() {
                Route::get('{project_id}', 'SiswaPageController@viewProject')->name('siswa-project-detail');

                Route::prefix('{project}')->group(function() {
                    Route::get('{fase}', 'SiswaPageController@viewFase')->name('siswa-fase-detail');
                    Route::post('{fase}/jawab', 'ProjectController@answerFase')->name('siswa-fase-answer');
                });

            });
        });


    });
});