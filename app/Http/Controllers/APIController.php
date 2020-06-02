<?php

namespace App\Http\Controllers;

use App\FaseKelompok;
use Illuminate\Http\Request;

class APIController extends Controller {
    
    public function __construct() {
        $this->middleware('guru');
    }

    public function faseDetail(Request $request) {
        $fk = FaseKelompok::where('id', $request->fase_id)->first();
        $res = ['success' => false];

        if($fk) {
            $res = [
                'success' => true,
                'data' => [
                    'id' => $fk->id,
                    'jawaban' => $fk->jawaban,
                    'jawaban_file' => $fk->jawaban_file,
                    'status' => $fk->status,
                    'nilai' => $fk->nilai,
                ]
            ];
        }

        return response()->json($res);
    }

}
