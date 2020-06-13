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
        $kelas = auth()->user()->detail->where('kode_kelas', $kode_kelas)->first();
        if(!$kelas) {
            abort(404);
        }
        return view('guru.kelas.detail', compact('kelas'));
    }   
    
    public function viewProject($kelas, $project) {
        $kelas = auth()->user()->detail->kelas->where('kode_kelas', $kelas)->first();
        
        if($kelas) {
            $project = $kelas->project->where('id', $project)->first();
            if($project) {
                $noGroup = $project->kelas->siswa;
                foreach ($project->kelompok as $kelompok) {
                    foreach ($kelompok->anggota() as $anggota) {
                        if($noGroup->contains($anggota)) {
                            $noGroup = $noGroup->keyBy('id');
                            $noGroup->forget($anggota->id);
                        }
                    }
                }
                return view('guru.project.detail', compact('project', 'noGroup'));
            }
        }

        abort(404);
    }

    public function viewFase($kelas, $project, $fase) {
        $kelas = auth()->user()->detail->kelas->where('kode_kelas', $kelas)->first();
        if($kelas) {
            $project = $kelas->project->where('id', $project)->first();
            if($project) {
                $fase = $project->fase->where('id', $fase)->first();
                if($fase) {
                    return view('guru.fase.detail', compact('fase'));
                }
            }
        }
        
        abort(404);
    }
    
    public function showDashboard() {
        $projects = new Collection;
        $jumlahSiswa = new Collection;
        foreach(auth()->user()->detail->kelas as $kelas) {
            $projects = $projects->merge($kelas->project);
            foreach($kelas->siswa as $siswa) {
                $jumlahSiswa->push($siswa);
            }
        }

        $jumlahSiswa = $jumlahSiswa->unique()->count();
        return view('guru.dashboard', compact('projects', 'jumlahSiswa'));
    }
    
}
