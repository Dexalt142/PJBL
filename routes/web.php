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
    Route::get('profile-setup', 'ProfileController@showSetupPage')->name('profile-setup');
    Route::post('profile-setup', 'ProfileController@setupProfile')->name('profile-setup-post');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');
});

Route::middleware('auth', 'user-validated')->group(function() {
    Route::post('profile/akun', 'ProfileController@updateAccount')->name('profile-account');
    Route::post('profile/bio', 'ProfileController@updateBio')->name('profile-bio');
    Route::post('profile/removepropics', 'ProfileController@removeProfilePictures')->name('profile-account-removepropics');
});

Route::middleware('guru', 'user-validated')->group(function() {
    Route::get('guru', 'GuruPageController@showDashboard')->name('guru-dashboard');
    
    Route::prefix('guru')->group(function() {
        Route::get('profile', 'GuruPageController@profilePage')->name('guru-profile');
        Route::get('project', 'ProjectController@showProjectPage')->name('guru-project');
        Route::get('kelas', 'KelasController@showKelasPage')->name('guru-kelas');

        Route::prefix('kelas')->group(function() {
            Route::post('buat', 'KelasController@buatKelas')->name('guru-kelas-create');
            
            Route::prefix('{kelas}')->group(function() {
                Route::get('/', 'GuruPageController@viewKelas')->name('guru-kelas-detail');

                Route::post('undang', 'KelasController@undangSiswa')->name('guru-kelas-invite');
                Route::post('edit', 'KelasController@editKelas')->name('guru-kelas-edit');
                Route::post('hapus', 'KelasController@hapusKelas')->name('guru-kelas-hapus');
                Route::post('hapussiswa', 'KelasController@hapusSiswa')->name('guru-kelas-hapussiswa');
                Route::post('gencode', 'KelasController@generateNewCode')->name('guru-kelas-gencode');
    
    
                Route::get('{project}', 'GuruPageController@viewProject')->name('guru-project-detail');
                
                Route::post('{project}/fase/buat', 'ProjectController@buatFase')->name('guru-fase-create');
                Route::post('project/buat', 'ProjectController@buatProject')->name('guru-project-create');
                Route::post('{project}/edit', 'ProjectController@editProject')->name('guru-project-edit');
                Route::post('{project}/hapus', 'ProjectController@hapusProject')->name('guru-project-hapus');
                Route::post('{project}/genkel', 'ProjectController@generateKelompok')->name('guru-kelompok-generate');
    
                Route::prefix('{project}')->group(function() {
                    Route::get('{fase}', 'GuruPageController@viewFase')->name('guru-fase-detail');
                    Route::post('{fase}/edit', 'ProjectController@editFase')->name('guru-fase-edit');
                    Route::post('{fase}/nilai', 'ProjectController@nilaiFase')->name('guru-fase-nilai');
                    Route::post('{fase}/hapus', 'ProjectController@hapusFase')->name('guru-fase-hapus');
                    Route::post('{fase}/hapusmateri', 'ProjectController@hapusFileMateri')->name('guru-fase-hapusmateri');
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
        Route::get('profile', 'SiswaPageController@profilePage')->name('siswa-profile');
        Route::get('kelas', 'SiswaPageController@showKelasPage')->name('siswa-kelas');
        Route::get('project', 'SiswaPageController@showProjectPage')->name('siswa-project');

        Route::prefix('kelas')->group(function() {
            Route::get('{kelas}', 'SiswaPageController@viewKelas')->name('siswa-kelas-detail');
            Route::post('gabung', 'KelasController@gabungKelas')->name('siswa-kelas-join');
            Route::post('keluar', 'KelasController@keluarKelas')->name('siswa-kelas-leave');

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