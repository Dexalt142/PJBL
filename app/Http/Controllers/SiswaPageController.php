<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Kelompok;
use App\FaseKelompok;
use App\Fase;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class SiswaPageController extends Controller {

    public function __construct() {
        $this->middleware('siswa');
    }

    public function viewKelas($kode_kelas) {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->firstOrFail();
        if(!auth()->user()->detail->kelas->contains($kelas)) {
            abort(404);
        }
        return view('siswa.kelas.detail', compact('kelas'));
    }    
    
    public function viewProject($kode_kelas, $id_project) {
        $kelas = Kelas::where('kode_kelas', $kode_kelas)->first();
        if($kelas->siswa->contains(auth()->user()->detail)) {
            $project = $kelas->project->where('id', $id_project)->first();
            if($project) {
                $kel = DB::table('kelompok_anggota')->where('siswa_id', auth()->user()->detail->id)->first();
                $kelompok = Kelompok::find($kel->id);

                return view('siswa.project.detail', compact('project', 'kelompok'));
            } else {
                abort(404);
            }
        } else {
            abort(404);
        }
    }

    public function viewFase($kelas, $project, $fase) {
        $kelompok = Kelompok::where('project_id', $project)->get();
        foreach($kelompok as $k) {
            if($k->anggota()->contains(auth()->user()->detail)) {
               $kelompok = $k; 
            }
        }

        $fase = Fase::where(['id' => $fase])->firstOrFail();
        $status = $fase->getStatus($kelompok->id);
        
        if($status == 1 || $status == 2) {
            $faseKelompok = FaseKelompok::where(['fase_id' => $fase->id, 'kelompok_id' => $kelompok->id])->first();
            return view('siswa.fase.detail', compact('fase', 'kelompok','faseKelompok'));
        } else {
            abort(404);
        }
    }
    
    public function showDashboard() {
        $projects = new Collection;
        foreach(auth()->user()->detail->kelas as $kelas) {
            $projects = $projects->merge($kelas->project);
        }
        return view('guru.dashboard', compact('projects'));
    }
    
}
