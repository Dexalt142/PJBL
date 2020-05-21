<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Guru;
use App\Siswa;

class ProfileController extends Controller {

    public function __construct() {
        $this->middleware('auth');
    }

    public function showSetupPage() {
        $user = auth()->user();
        if($user->user_type == "guru") {
            if(!Guru::where(['user_id' => $user->id])->first()) {
                return view('guru.setup');
            }
        } else if($user->user_type == "siswa") {
            if(!Siswa::where(['user_id' => $user->id])->first()) {
                return view('siswa.setup');
            }
        }
        return redirect($user->user_type);
    }

    public function setupProfile(Request $request) {
        $utype = auth()->user()->user_type;
        if($utype == "guru") {
            $validated = $request->validate([
                'nip' => ['required', 'string', 'max:255'],
                'nama_lengkap' => ['required', 'string', 'max:255'],
                'tanggal_lahir' => ['required', 'date'],
                'jenis_kelamin' => ['required', 'string', 'regex:(1|2)'],
                'alamat' => ['required', 'string'],
                'agama' => ['required', 'regex:(islam|kristen|katolik|buddha|hindu|konghucu|lainnya)']
            ]);
            $validated['user_id'] = auth()->user()->id;
            $guru = Guru::create($validated);
    
            if($guru) {
                return redirect()->route('guru-dashboard');
            }
        } else if($utype == "siswa") {
            $validated = $request->validate([
                'nis' => ['required', 'string', 'max:255'],
                'nama_lengkap' => ['required', 'string', 'max:255'],
                'tanggal_lahir' => ['required', 'date'],
                'jenis_kelamin' => ['required', 'string', 'regex:(1|2)'],
                'alamat' => ['required', 'string'],
                'agama' => ['required', 'regex:(islam|kristen|katolik|buddha|hindu|konghucu|lainnya)']
            ]);
            $validated['user_id'] = auth()->user()->id;
            $siswa = Siswa::create($validated);
    
            if($siswa) {
                return redirect()->route('siswa-dashboard');
            }
        }
    }

}
