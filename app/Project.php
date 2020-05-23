<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    
    protected $table = 'project';

    protected $fillable = [
        'nama_project', 'kelas_id',
    ];

    public function kelas() {
        return $this->belongsTo('App\Kelas');
    }

    public function kelompok() {
        return $this->belongsToMany('App\Kelompok', 'project_kelompok');
    }

}
