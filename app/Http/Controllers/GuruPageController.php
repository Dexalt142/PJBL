<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Kelas;

class GuruPageController extends Controller {

    public function __construct() {
        $this->middleware('guru');
    }

    public function viewKelas($kode_kelas) {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->firstOrFail();
        return view('guru.kelas.detail', compact('kelas'));
    }
    
    
}
