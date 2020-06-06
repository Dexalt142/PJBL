<?php

namespace App\Http\Controllers;

use App\FaseKelompok;
use App\Kelompok;
use App\Siswa;
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
                    'evaluasi' => $fk->evaluasi,
                ]
            ];
        }

        return response()->json($res);
    }

    public function getAnggotaKelompok(Request $request) {
        $kelompok = Kelompok::where('id', $request->kelompok_id)->first();
        $res = ['success' => false];

        if($kelompok) {
            $res['data'] = [];
            if($kelompok->anggota()->count() > 0) {
                foreach ($kelompok->anggota() as $anggota) {
                    $res['data'][] = [
                        'id' => $anggota->getKelasSiswaId($kelompok->project->kelas_id),
                        'nama_lengkap' => $anggota->nama_lengkap
                    ];
                }
            }
            $res['success'] = true;
        }

        return response()->json($res);
    }

}
