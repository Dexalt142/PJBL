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
    
    private function getKelas($kode_kelas) {
        return auth()->user()->detail->kelas->where('kode_kelas', $kode_kelas)->first();
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

        $kelas = $this->getKelas($kelas);
        if($kelas) {
            $kelas->nama = $validated['nama_kelas'];
    
            if($kelas->save()) {
                return redirect()->route('guru-kelas-detail', $kelas->kode_kelas);
            }
        }

        return redirect()->back();
    }

    public function hapusKelas(Request $request, $kelas) {
        $validated = $request->validate([
            'kode_kelas' => ['required', 'string'],
        ]);

        $kelas = $this->getKelas($kelas);
        if($kelas) {
            $kelas->delete();
        }

        return redirect()->route('guru-dashboard');
    }

    public function generateNewCode(Request $request, $kelas) {
        $validated = $request->validate([
            'kode_kelas' => ['required', 'string'],
        ]);

        $kelas = $this->getKelas($validated['kode_kelas']);
        if($kelas) {
            $kelas->kode_kelas = Str::random(8);
    
            if($kelas->save()) {
                return response()->json(['success' => 'true', 'kode_kelas' => $kelas->kode_kelas]);
            }
        }

        return response()->json(['success' => 'false']);
    }

    public function undangSiswa(Request $request) {
        $validated = $request->validate([
            'email_siswa' => ['required', 'email'],
            'kelas_id' => ['integer']
        ]);

        $siswa = User::where(['email' => $validated['email_siswa'], 'user_type' => 'siswa'])->first();
        if($siswa) {
            $kelas = auth()->user()->detail->kelas->where('id', $validated['kelas_id'])->first();
            if(!$kelas->siswa->contains('id', $siswa->detail->id)) {
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

        $kelas = $this->getKelas($validated['kode_kelas']);
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

    public function keluarKelas(Request $request) {
        $validated = $request->validate([
            'kode_kelas' => ['required', 'string'],
        ]);
        $kelas = $this->getKelas($validated['kode_kelas']);
        if($kelas) {
            foreach($kelas->siswa as $siswa) {
                if($siswa->id == auth()->user()->detail->id) {
                    DB::table('kelas_siswa')->where(['id' => $siswa->pivot->id])->delete();
                    return redirect()->route('siswa-dashboard');
                }
            }
        }

        return redirect()->back();
    }

    public function hapusSiswa(Request $request, $kelas) {
        $res = ['success' => false];
        $kelas = $this->getKelas($kelas);
        if($kelas) {
            foreach($kelas->siswa as $siswa) {
                if($siswa->pivot->id == $request->siswa) {
                    DB::table('kelas_siswa')->where(['id' => $siswa->pivot->id])->delete();
                    $res['success'] = true;
                }
            }
        }

        return response()->json($res);
    }

}
