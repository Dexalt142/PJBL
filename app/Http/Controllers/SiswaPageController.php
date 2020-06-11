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
    
    public function viewProject($kelas, $project_id) {
        $kelas = Kelas::where('kode_kelas', $kelas)->first();

        if($kelas && $kelas->siswa->contains(auth()->user()->detail)) {
            $project = $kelas->project->where('id', $project_id)->first();

            if($project) {
                $idKelasSiswa = $kelas->siswa->where('id', auth()->user()->detail->id)->first()->pivot->id;
                $kel = DB::table('kelompok_anggota')->where('siswa_id', $idKelasSiswa)->get();
                $kelompok = null;

                foreach ($kel as $k) {
                    $ktemp = Kelompok::find($k->kelompok_id);
                    if($ktemp->project_id == $project_id) {
                        $kelompok = $ktemp;
                    }
                }

                return view('siswa.project.detail', compact('project', 'kelompok'));
            }
        }

        abort(404);
    }

    public function viewFase($kelas, $project, $fase) {
        $kelas = Kelas::where('kode_kelas', $kelas)->first();

        if($kelas && $kelas->siswa->contains(auth()->user()->detail)) {
            $pr = $kelas->project->where('id', $project)->first();
            if(!$pr) {
                abort(404);
            }
            $allKelompok = Kelompok::where('project_id', $pr->id)->get();
            $kelompok = null;
            
            foreach($allKelompok as $k) {
                if($k->anggota()->contains(auth()->user()->detail)) {
                    $kelompok = $k; 
                }
            }

            if($kelompok) {
                $fase = $pr->fase->where('id', $fase)->first();
                if($fase) {
                    $status = $fase->getStatus($kelompok->id);
                    
                    if($status == 1 || $status == 2) {
                        $faseKelompok = FaseKelompok::where(['fase_id' => $fase->id, 'kelompok_id' => $kelompok->id])->first();
                        return view('siswa.fase.detail', compact('fase', 'kelompok','faseKelompok'));
                    }
                }
            }
        }
        
        abort(404);
    }
    
    public function showDashboard() {
        $projects = new Collection;
        foreach(auth()->user()->detail->kelas as $kelas) {
            $projects = $projects->merge($kelas->project);
        }
        return view('guru.dashboard', compact('projects'));
    }

    public function showKelasPage() {
        $listKelas = auth()->user()->detail->kelas;
        return view('siswa.kelas.kelas', compact('listKelas'));
    }

    public function showProjectPage() {
        $projects = new Collection;
        foreach(auth()->user()->detail->kelas as $kelas) {
            $projects = $projects->merge($kelas->project);
        }
        $projects = $projects->sortByDesc('created_at');
        return view('siswa.project.project', compact('projects'));
    }
}
