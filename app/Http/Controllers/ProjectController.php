<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller {

    public function buatProject(Request $request) {
        $validated = $request->validate([
            'kelas_id' => ['required', 'integer', 'exists:kelas,id'],
            'nama_project' => ['required', 'string', 'min:5'],
        ]);


        if(Project::create($validated)) {
            return redirect()->to($request->r);
        }
    }
    
}
