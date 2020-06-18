<?php

namespace App\Http\Controllers;

use App\User;
use App\Guru;
use App\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

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
    
    public function updateAccount(Request $request) {
        $user = auth()->user();
        $validated = $request->validate([
            'profile_picture' => ['nullable', 'sometimes', 'mimes:jpeg,jpg,png', 'max:2048'],
            'email' => ['email', 'required', 'string'],
            'password' => ['nullable', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed']
        ]);
        
        if($request->file('profile_picture')) {
            $file = $request->file('profile_picture');
            $filename = Str::orderedUuid()->toString().'.'.$file->extension();
            $path = Storage::disk('profile_pictures')->putFileAs('', $file, $filename);

            if($user->profile_picture) {
                Storage::disk('profile_pictures')->delete($user->profile_picture);    
            }
            $user->profile_picture = $filename;
        }

        if($validated['email'] != $user->email) {
            $emailCheck = User::where('email', $validated['email'])->first();
            if($emailCheck) {
                return redirect()->back()->withErrors(['email' => 'Email sudah digunakan.']);
            }
            
            $user->email = $validated['email'];
        }
        
        if($validated['new_password']) {
            if(empty($validated['password'])) {
                return redirect()->back()->withErrors(['password' => 'Masukkan password anda saat ini.']);
            }
            if(!Hash::check($validated['password'], $user->password)) {
                return redirect()->back()->withErrors(['password' => 'Password anda salah.']);
            }

            $user->password = Hash::make($validated['new_password']);
        }
        
        if($user->save()) {
            return redirect()->back()->with('accountUpdate', 'Perubahan berhasil disimpan');
        }
    }

    public function updateBio(Request $request) {
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
            $guruDetail = auth()->user()->detail;
            $guruDetail->nip = $validated['nip'];
            $guruDetail->nama_lengkap = $validated['nama_lengkap'];
            $guruDetail->tanggal_lahir = $validated['tanggal_lahir'];
            $guruDetail->jenis_kelamin = $validated['jenis_kelamin'];
            $guruDetail->alamat = $validated['alamat'];
            $guruDetail->agama = $validated['agama'];
            
            if($guruDetail->save()) {
                return redirect()->back()->with('bioUpdate', 'Perubahan berhasil disimpan');
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
            $siswaDetail = auth()->user()->detail;
            $siswaDetail->nis = $validated['nis'];
            $siswaDetail->nama_lengkap = $validated['nama_lengkap'];
            $siswaDetail->tanggal_lahir = $validated['tanggal_lahir'];
            $siswaDetail->jenis_kelamin = $validated['jenis_kelamin'];
            $siswaDetail->alamat = $validated['alamat'];
            $siswaDetail->agama = $validated['agama'];
            
            if($siswaDetail->save()) {
                return redirect()->back()->with('bioUpdate', 'Perubahan berhasil disimpan');
            }
        } 
    }

    public function removeProfilePictures(Request $request) {
        $res['success'] = false;
        $user = auth()->user();
        if($request['profile_picture'] == $user->profile_picture) {
            Storage::disk('profile_pictures')->delete($user->profile_picture);
            $user->profile_picture = null;
            if($user->save()) {
                $res['success'] = true;
            }
        }

        return response()->json($res);
    }

}
