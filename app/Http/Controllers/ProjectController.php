<?php

namespace App\Http\Controllers;

use App\Project;
use App\Kelompok;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ProjectController extends Controller {

    public function __construct() {
        $this->middleware('guru', ['only' => ['buatProject', 'showProjectPage', 'viewProject']]);
    }

    public function buatProject(Request $request) {
        $validated = $request->validate([
            'kelas_id' => ['required', 'integer', 'exists:kelas,id'],
            'nama_project' => ['required', 'string', 'min:5'],
        ]);


        if(Project::create($validated)) {
            return redirect()->to($request->r);
        }
    }

    public function showProjectPage() {
        $projects = new Collection;
        foreach(auth()->user()->detail->kelas as $kelas) {
            $projects = $projects->merge($kelas->project);
        }
        return view('guru.project.project', compact('projects'));
    }

    public function viewProject($id_project) {
        $project = Project::where('id', $id_project)->firstOrFail();
        if($project->kelas->guru != auth()->user()->detail) {
            abort(404);
        }
        return view('guru.project.detail', compact('project'));
    }

    public function generateKelompok(Request $request) {
        $validated = $request->validate([
            'id_project' => ['exists:project,id', 'required'],
            'jumlah_siswa' => ['required', 'integer']
        ]);

        $proj = Project::find($validated['id_project']);
        $siswaList = $proj->kelas->siswa->shuffle();
        $max = $validated['jumlah_siswa'];

        if($max > $siswaList->count() || $max < 1) {
            return redirect()->back();
        } else {
            $n = 1;
            $k = 1;
            foreach ($siswaList as $siswa) {
                $nama = "Kelompok $k";
                $kelompok = Kelompok::where(['project_id' => $proj->id, 'nama_kelompok' => $nama])->first();
                
                if(!$kelompok) {
                    $kelompok = Kelompok::create(['project_id' => $proj->id, 'nama_kelompok' => $nama]);
                }
                $ksid = DB::table('kelas_siswa')->where(['siswa_id' => $siswa->id, 'kelas_id' => $proj->kelas->id])->first('id');
                
                DB::table('kelompok_anggota')->insert(['kelompok_id' => $kelompok->id, 'siswa_id' => $ksid->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
                    
                if($n % $max == 0) {
                    $k++;
                }
                $n++;
            }

        }

        return redirect()->back();
    }
    
}
