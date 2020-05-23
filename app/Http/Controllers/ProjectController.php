<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

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
    
}
