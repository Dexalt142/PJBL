<?php

namespace App\Http\Controllers;

use App\Kelas;
use App\Project;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

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
    
    public function viewProject($id_project) {
        $project = Project::where('id', $id_project)->firstOrFail();
        if($project->kelas->guru != auth()->user()->detail) {
            abort(404);
        }
        return view('siswa.project.detail', compact('project'));
    }
    
    public function showDashboard() {
        $projects = new Collection;
        foreach(auth()->user()->detail->kelas as $kelas) {
            $projects = $projects->merge($kelas->project);
        }
        return view('guru.dashboard', compact('projects'));
    }
    
}
