<?php

namespace App\Http\Controllers;

use App\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class KelasController extends Controller {
    
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

}
