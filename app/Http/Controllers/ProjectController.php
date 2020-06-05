<?php

namespace App\Http\Controllers;

use App\Project;
use App\Kelompok;
use App\FaseKelompok;
use App\Fase;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use \Illuminate\Support\Str;

class ProjectController extends Controller {

    public function __construct() {
        $this->middleware('guru', ['only' => ['buatProject', 'buatFase', 'showProjectPage', 'viewProject']]);
        $this->middleware('siswa', ['only' => ['answerFase']]);
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

    public function viewProject($kelas, $project) {
        $project = Project::where('id', $project)->firstOrFail();
        if($project->kelas->guru != auth()->user()->detail) {
            abort(404);
        }
        return view('guru.project.detail', compact('project'));
    }

    public function viewFase($kelas, $project, $fase) {
        $fase = Fase::where('id', $fase)->firstOrFail();
        if($fase->project->kelas->guru != auth()->user()->detail) {
            abort(404);
        }
        return view('guru.fase.detail', compact('fase'));
    }

    public function buatFase($kelas, $project, Request $request) {
        $validated = $request->validate([
            'nama_fase' => ['required', 'string'],
            'materi' => ['required', 'string'],
            'fase_type' => ['required', 'string', 'regex:(materi|tes)'],
            'deadline' => ['required', 'date'],
        ]);

        $a = Fase::where(['project_id' => $project])->orderBy('fase_ke', 'DESC')->first();
        $validated['project_id'] = $project;
        $validated['fase_ke'] = 1;

        if($a) {
            $validated['fase_ke'] = $a->fase_ke + 1;
        } 
        
        $fase = Fase::create($validated);
        if($fase) {
            return redirect()->back();
        }
    }

    public function editFase($kelas, $project, $fase, Request $request) {
        $validated = $request->validate([
            'id' => ['required', 'integer'],
            'nama_fase' => ['required', 'string'],
            'materi' => ['required', 'string'],
            'fase_type' => ['required', 'string', 'regex:(materi|tes)'],
            'deadline' => ['required', 'date'],
        ]);

        $fase = Fase::where('id', $validated['id'])->first();
        $fase->nama_fase = $validated['nama_fase'];
        $fase->materi = $validated['materi'];
        $fase->fase_type = $validated['fase_type'];
        $fase->deadline = $validated['deadline'];
        if($fase->save()) {
            return redirect()->back();
        }
    }

    public function answerFase(Request $request) {
        $validated = $request->validate([
            'fase_id' => ['integer', 'exists:fase,id'],
            'kelompok_id' => ['integer', 'exists:kelompok,id'],
            'jawaban' => ['nullable', 'sometimes', 'string'],
            'jawaban_file' => ['nullable', 'sometimes', 'mimes:docx,doc,pptx,ppt,pdf,rar,zip'],
        ]);
        

        $validated['status'] = 1;
        $fk = FaseKelompok::where(['fase_id' => $validated['fase_id'], 'kelompok_id' => $validated['kelompok_id']])->first();
        if($fk) {
            if($request->file('jawaban_file')) {
                $filename = Str::random(10).'_'.$request->file('jawaban_file')->getClientOriginalName();
                $path = Storage::disk('answer_files')->putFileAs('', $request->file('jawaban_file'), $filename);
    
                $fk->jawaban_file = $filename;
            }
            $fk->jawaban = $validated['jawaban'];
            $fk->save();
        } else {
            if($request->file('jawaban_file')) {
                $filename = Str::random(10).'_'.$request->file('jawaban_file')->getClientOriginalName();
                $path = Storage::disk('answer_files')->putFileAs('', $request->file('jawaban_file'), $filename);
    
                $validated['jawaban_file'] = $filename;
            }

            FaseKelompok::create($validated);
        }

        return redirect()->back()->with('jawabanSuccess', true);
    }

    public function nilaiFase($kelas, $project, $fase, Request $request) {
        $validated = $request->validate([
            'fk_id' => ['required', 'integer'],
            'nilai' => ['required', 'integer'],
            'evaluasi' => ['nullable', 'string'],
        ]);

        $fk = FaseKelompok::where('id', $validated['fk_id'])->first();
        $fk->nilai = $validated['nilai'];
        $fk->evaluasi = $validated['evaluasi'];
        $fk->status = '2';
        if($fk->save()) {
            return redirect()->back();
        }
    }

    public function generateKelompok($kelas, $project, Request $request) {
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
