<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fase extends Model {

    protected $table = "fase";

    protected $fillable = [
        'nama_fase', 'deskripsi', 'deadline', 'fase_type', 'project_id'
    ];

    public function project() {
        return $this->belongsTo('App\Project');
    }

    public function kelompok(){
        return $this->hasMany('App\Kelompok')->withPivot('jawaban', 'jawaban_file', 'status');
    }
    
}
