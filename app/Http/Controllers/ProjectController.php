<?php

namespace App\Http\Controllers;

use App\Project;
use App\Kelompok;
use App\FaseKelompok;
use App\Fase;
use App\FileMateri;
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

    public static function sanitize($string){
        $rep = ['\\', '/', ':', ';', '?', '*', '&', '<', '>', '#', '$', ' ', '|', '+', '\'', '\"'];
        $sanitized = str_replace($rep, '-', $string);
        return $sanitized;
    }

    private function getKelas($kelas) {
        return auth()->user()->detail->kelas->where('kode_kelas', $kelas)->first();
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

    public function editProject(Request $request, $kelas) {
        $validated = $request->validate([
            'nama_project' => ['required', 'string', 'min:5'],
        ]);

        $kelas = $this->getKelas($kelas);
        if($kelas) {
            $project = $kelas->project->where('id', $request->project)->first();
            if($project) {
                $project->nama_project = $request->nama_project;
                $project->save();
                return redirect()->back();
            }
        }
        return redirect()->back()->withErrors(['nama_project' => 'Terjadi kesalahan']);
    }

    public function hapusProject(Request $request, $kelas, $project) {
        $kelas = $this->getKelas($kelas);
        if($kelas) {
            $project = $kelas->project->where('id', $request->project)->first();
            if($project) {
                $project->delete();
                return redirect()->route('guru-kelas-detail', $kelas->kode_kelas);
            }
        }

        return redirect()->back();
    }

    public function showProjectPage() {
        $projects = new Collection;
        foreach(auth()->user()->detail->kelas as $kelas) {
            $projects = $projects->merge($kelas->project);
        }
        return view('guru.project.project', compact('projects'));
    }

    public function buatFase($kelas, $project, Request $request) {
        
        $validated = $request->validate([
            'nama_fase' => ['required', 'string'],
            'materi' => ['required', 'string'],
            'fase_type' => ['required', 'string', 'regex:(materi|tes)'],
            'deadline' => ['required', 'date'],
            'fileMateri.*' => ['nullable', 'sometimes', 'mimes:docx,doc,pptx,ppt,pdf,rar,zip', 'max:10240'],
        ]);

        $kelas = $this->getKelas($kelas);
        if($kelas) {
            $project = $kelas->project->where('id', $project)->first();
            if($project) {
                $a = Fase::where(['project_id' => $project->id])->orderBy('fase_ke', 'DESC')->first();
                $newFase = new Fase;    
                $newFase->fase_ke = 1;    
                if($a) {
                    $newFase->fase_ke = $a->fase_ke + 1;
                }

                $newFase->project_id = $project->id;
                $newFase->nama_fase = $validated['nama_fase'];
                $newFase->materi = $validated['materi'];
                $newFase->fase_type = $validated['fase_type'];
                $newFase->deadline = $validated['deadline'];
                
                if($newFase->save()) {
                    if($request->file('fileMateri')) {
                        foreach($request->file('fileMateri') as $file) {
                            $filename = Str::random(10).'_'.ProjectController::sanitize($file->getClientOriginalName());
                            $path = Storage::disk('materi')->putFileAs($kelas->kode_kelas, $file, $filename);
                            $fileMateri = FileMateri::create(['nama_file' => $filename, 'fase_id' => $newFase->id]);
                        }
                    }

                    return redirect()->back()->with('faseSuccess', 'Berhasil membuat fase baru');
                }
            }
        }

        return redirect()->back()->withErrors(['faseFail' => 'Gagal membuat fase']);

    }

    public function editFase($kelas, $project, $fase, Request $request) {
        $validated = $request->validate([
            'id' => ['required', 'integer'],
            'nama_fase' => ['required', 'string'],
            'materi' => ['required', 'string'],
            'fase_type' => ['required', 'string', 'regex:(materi|tes)'],
            'deadline' => ['required', 'date'],
            'fileMateri.*' => ['nullable', 'sometimes', 'mimes:docx,doc,pptx,ppt,pdf,rar,zip', 'max:10240'],
        ]);

        $kelas = $this->getKelas($kelas);
        if($kelas) {
            $project = $kelas->project->where('id', $project)->first();
            if($project) {
                $fase = $project->fase->where('id', $validated['id'])->first();
                if($fase) {
                    $fase->nama_fase = $validated['nama_fase'];
                    $fase->materi = $validated['materi'];
                    $fase->fase_type = $validated['fase_type'];
                    $fase->deadline = $validated['deadline'];
    
                    if($fase->save()) {
                        if($request->file('fileMateri')) {
                            foreach($request->file('fileMateri') as $file) {
                                $filename = Str::random(10).'_'.ProjectController::sanitize($file->getClientOriginalName());
                                $path = Storage::disk('materi')->putFileAs($kelas->kode_kelas, $file, $filename);
                                $fileMateri = FileMateri::create(['nama_file' => $filename, 'fase_id' => $fase->id]);
                            }
                        }

                        return redirect()->back()->with('faseSuccess', 'Berhasil mengedit fase');
                    }
                }
            }
        }
        
        return redirect()->back()->withErrors(['faseFail' => 'Gagal mengedit fase']);
    }

    public function hapusFase($kelas, $project, $fase, Request $request) {
        $kelas = $this->getKelas($kelas);
        if($kelas) {
            $project = $kelas->project->where('id', $project)->first();
            if($project) {
                $pfase = $project->fase;
                $fase = $pfase->where('id', $fase)->first();
                if($pfase->isNotEmpty() && $fase) {
                    if($fase->fase_ke == $pfase->count()) {
                        $fase->delete();

                    } else {
                        $fase_ke = $fase->fase_ke;
                        $nextFase = $pfase->where('fase_ke', '>', $fase_ke);
                        
                        if($fase->fileMateri->isNotEmpty()) {
                            foreach($fase->fileMateri as $fileMateri) {
                                Storage::disk('materi')->delete($kelas->kode_kelas.'/'.$fileMateri->nama_file);
                                $fileMateri->delete();
                            }
                        }

                        if($fase->delete()) {
                            foreach($nextFase as $nf) {
                                $nf->fase_ke = $nf->fase_ke - 1;
                                $nf->save();
                            }
                        }
                    }

                    return redirect()->route('guru-project-detail', [$kelas->kode_kelas, $project->id]);
                }
            }
        }

        return redirect()->back();
    }

    public function hapusFileMateri($kelas, $project, $fase, Request $request) {
        $res = ['success' => false];
        $kelas = $this->getKelas($kelas);

        if($kelas) {
            $project = $kelas->project->where('id', $project)->first();
            if($project) {
                $fase = $project->fase->where('id', $fase)->first();
                if($fase) {
                    $fileToBeDeleted = $fase->fileMateri->where('id', $request->idf)->first();
                    if($fileToBeDeleted) {
                        Storage::disk('materi')->delete($kelas->kode_kelas.'/'.$fileToBeDeleted->nama_file);
                        $fileToBeDeleted->delete();
                        $res['success'] = true;

                        return response()->json($res);
                    }
                }
            }
        }

        return response()->json($res);
    }

    public function answerFase(Request $request) {
        $validated = $request->validate([
            'fase_id' => ['integer', 'exists:fase,id'],
            'kelompok_id' => ['integer', 'exists:kelompok,id'],
            'jawaban' => ['nullable', 'sometimes', 'string'],
            'jawaban_file' => ['nullable', 'sometimes', 'mimes:docx,doc,pptx,ppt,pdf,rar,zip', 'max:10240'],
        ]);

        $fa = Fase::where('id', $validated['fase_id'])->first();
        if($fa) {
            if($fa->deadline->greaterThan(now())) {
                $validated['status'] = 1;
                $fk = FaseKelompok::where(['fase_id' => $validated['fase_id'], 'kelompok_id' => $validated['kelompok_id']])->first();
                if($fk) {
                    if($request->file('jawaban_file')) { 
                        $filename = Str::random(10).'_'.ProjectController::sanitize($request->file('jawaban_file')->getClientOriginalName());
                        $path = Storage::disk('answer_files')->putFileAs('', $request->file('jawaban_file'), $filename);
            
                        $fk->jawaban_file = $filename;
                    }
                    $fk->jawaban = $validated['jawaban'];
                    $fk->save();
                } else {
                    if($request->file('jawaban_file')) {
                        $filename = Str::random(10).'_'.ProjectController::sanitize($request->file('jawaban_file')->getClientOriginalName());
                        $path = Storage::disk('answer_files')->putFileAs('', $request->file('jawaban_file'), $filename);
            
                        $validated['jawaban_file'] = $filename;
                    }
        
                    FaseKelompok::create($validated);
                }
        
                return redirect()->back()->with('jawabanSuccess', true);
            }
        }
        
        return redirect()->back()->with('jawabanSuccess', false);
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
                
                DB::table('kelompok_anggota')->insert(['kelompok_id' => $kelompok->id, 'siswa_id' => $siswa->pivot->id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
                    
                if($n % $max == 0) {
                    $k++;
                }
                $n++;
            }

        }

        return redirect()->back();
    }

    public function hapusAnggota(Request $request) {
        $res = ['success' => false];
        $kelompok = Kelompok::where('id', $request->kelompok_id)->first();
        if($kelompok) {
            if($kelompok->hapusAnggota($request->siswa_id)) {
                $res['success'] = true;
            }
        }
        return response()->json($res);
    }

    public function tambahAnggota(Request $request) {
        $kelompok = Kelompok::where('id', $request->tambah_kel_id)->first();
        if($kelompok) {
            DB::table('kelompok_anggota')->insert(['kelompok_id' => $kelompok->id, 'siswa_id' => $request->siswa_id, 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()]);
        }

        return redirect()->back();
    }
    
}
