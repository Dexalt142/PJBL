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

    private function getKelas($kode_kelas) {
        return auth()->user()->detail->kelas->where('kode_kelas', $kode_kelas)->first();
    }

    public function viewKelas($kode_kelas) {
        $kelas = $this->getKelas($kode_kelas);
        if(!$kelas) {
            abort(404);
        }
        return view('guru.kelas.detail', compact('kelas'));
    }   
    
    public function viewProject($kelas, $project) {
        $kelas = $this->getKelas($kelas);
        
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
        $kelas = $this->getKelas($kelas);
        
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
        $jumlahFase = new Collection;
        foreach(auth()->user()->detail->kelas as $kelas) {
            $projects = $projects->merge($kelas->project);
            foreach($kelas->siswa as $siswa) {
                $jumlahSiswa->push($siswa);
            }
            foreach($kelas->project as $project) {
                $jumlahFase = $jumlahFase->merge($project->fase);
            }
        }

        $jumlahSiswa = $jumlahSiswa->unique()->count();
        $jumlahFase = $jumlahFase->count();
        return view('guru.dashboard', compact('projects', 'jumlahSiswa', 'jumlahFase'));
    }

    public function profilePage() {
        $user = auth()->user();
        $userDetail = $user->detail;
        return view('guru.profile', compact('user', 'userDetail'));
    }
}
