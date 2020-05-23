<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class GuruPageController extends Controller {

    public function __construct() {
        $this->middleware('guru');
    }

    public function viewKelas($kode_kelas) {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->firstOrFail();
        if($kelas->guru != auth()->user()->detail) {
            abort(404);
        }
        return view('guru.kelas.detail', compact('kelas'));
    }    
    
    public function showDashboard() {
        $projects = new Collection;
        foreach(auth()->user()->detail->kelas as $kelas) {
            $projects = $projects->merge($kelas->project);
        }
        return view('guru.dashboard', compact('projects'));
    }
    
}
