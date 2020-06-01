<?php

namespace App;

use App\FaseKelompok;
use Illuminate\Database\Eloquent\Model;

class Fase extends Model {

    protected $table = "fase";

    protected $fillable = [
        'nama_fase', 'deskripsi', 'deadline', 'fase_type', 'fase_ke', 'project_id'
    ];

    public function project() {
        return $this->belongsTo('App\Project');
    }

    public function kelompok(){
        return $this->belongsToMany('App\Kelompok')->withPivot('jawaban', 'jawaban_file', 'status');
    }

    public function faseDetail() {
        return FaseKelompok::where('fase_id', $this->id)->first();
    }

    public function allFaseKelompok() {
        return $this->hasMany('App\FaseKelompok');
    }

    public function getStatus($kelompok) {
        $status = '';
        if($this->fase_ke == 1) {
            $status = 'available';
        } else {
            $fk = FaseKelompok::where(['fase_id' => $this->id, 'kelompok_id' => $kelompok->id])->first();
            if($fk && $fk->status == 'selesai') {
                $status = 'done';
            } else {
                $status = 'locked';
            }
        }

        return $status;
    }
    
}
