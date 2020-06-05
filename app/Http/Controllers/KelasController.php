<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class KelasController extends Controller {

    public function showKelasPage() {
        $listKelas = auth()->user()->detail->kelas;
        return view('guru.kelas.kelas', compact('listKelas'));
    }
    
    public function buatKelas(Request $request) {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'min:5'],
        ]);

        $validated['nama'] = $validated['nama_kelas'];
        $validated['guru_id'] = auth()->user()->detail->id;
        $validated['kode_kelas'] = Str::random(8);
        unset($validated['nama_kelas']);

        if(Kelas::create($validated)) {
            return redirect()->route('guru-dashboard');
        }
    }

    public function editKelas(Request $request, $kelas) {
        $validated = $request->validate([
            'nama_kelas' => ['required', 'string', 'min:5'],
        ]);

        $k = Kelas::where(['kode_kelas' => $kelas])->firstOrFail();
        $k->nama = $validated['nama_kelas'];

        if($k->save()) {
            return redirect()->route('guru-kelas-detail', $kelas);
        }
    }

    public function generateNewCode(Request $request, $kelas) {
        $validated = $request->validate([
            'kode_kelas' => ['required', 'string'],
        ]);

        $k = Kelas::where(['kode_kelas' => $kelas])->firstOrFail();
        $k->kode_kelas = Str::random(8);

        if($k->save()) {
            return response()->json(['success' => 'true', 'kode_kelas' => $k->kode_kelas]);
        } else {
            return response()->json(['success' => 'false']);
        }
    }

    public function undangSiswa(Request $request) {
        $validated = $request->validate([
            'email_siswa' => ['required', 'email'],
            'kelas_id' => ['integer']
        ]);

        $siswa = User::where(['email' => $validated['email_siswa'], 'user_type' => 'siswa'])->first();
        if($siswa) {
            if(!Kelas::find($validated['kelas_id'])->siswa->contains('id', $siswa->detail->id)) {
                $save = DB::table('kelas_siswa')->insert(['kelas_id' => $validated['kelas_id'], 'siswa_id' => $siswa->detail->id, 'tanggal_masuk' => Carbon::now()->toDateTimeString()]);
                if($save) {
                    return redirect()->to($request->r);
                }
            } else {
                return redirect()->to($request->r)->withErrors(['undang_siswa' => 'Siswa sudah berada di dalam kelas']);
            }
        } else {
            return redirect()->to($request->r)->withErrors(['undang_siswa' => 'Siswa tidak ditemukan']);
        }
        
    }

    public function gabungKelas(Request $request) {
        $validated = $request->validate([
            'kode_kelas' => ['required', 'string'],
        ]);

        $kelas = Kelas::where(['kode_kelas' => $validated['kode_kelas']])->first();
        if($kelas) {
            if(!$kelas->siswa->contains(auth()->user()->detail)) {
                $kelas->siswa()->attach(auth()->user()->detail, ['tanggal_masuk' => Carbon::now()]);
                return redirect()->back();
            } else {
                return redirect()->to($request->r)->withErrors(['kode_kelas' => 'Anda sudah bergabung di kelas ini']);
            }
        } else {
            return redirect()->to($request->r)->withErrors(['kode_kelas' => 'Kelas tidak ditemukan']);
        }
    }

}
