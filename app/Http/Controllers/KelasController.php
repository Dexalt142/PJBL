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

}
