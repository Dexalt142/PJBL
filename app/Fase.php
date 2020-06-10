<?php

namespace App;

use App\FaseKelompok;
use Illuminate\Database\Eloquent\Model;

class Fase extends Model {

    protected $table = "fase";

    protected $fillable = [
        'nama_fase', 'materi', 'deadline', 'fase_type', 'fase_ke', 'project_id'
    ];

    protected $dates = ['deadline'];

    public function project() {
        return $this->belongsTo('App\Project');
    }

    public function kelompok(){
        return $this->belongsToMany('App\Kelompok')->withPivot('jawaban', 'jawaban_file', 'nilai', 'status');
    }

    public function fileMateri() {
        return $this->hasMany('App\FileMateri');
    }

    public function faseDetail($kelompok) {
        return FaseKelompok::where(['fase_id' => $this->id, 'kelompok_id' => $kelompok])->first();
    }

    public function allFaseKelompok() {
        return $this->hasMany('App\FaseKelompok');
    }

    public function getStatus($kelompok) {
        $status = 0;
        $det = $this->faseDetail($kelompok);
        if($this->fase_ke == 1) {
            if($det) {
                if($det->status == "1" || $det->status == "2") {
                    $status = 2;
                }
            } else {
                $status = 1;
            }
        } else {
            $prevFase = Fase::where(['project_id' => $this->project_id, 'fase_ke' => $this->fase_ke - 1])->first();
            $prev = FaseKelompok::where(['fase_id' => $prevFase->id, 'kelompok_id' => $kelompok])->first();
            if($prev) {
                if($prev->status == "2") {
                    $status = 1;
                }
            }
        }
        return $status;
    }
    
}
