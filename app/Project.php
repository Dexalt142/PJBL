<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    
    protected $table = 'project';

    protected $fillable = [
        'nama_project', 'kelas_id',
    ];

    public function fase() {
        return $this->hasMany('App\Fase');
    }

    public function kelas() {
        return $this->belongsTo('App\Kelas');
    }

    public function kelompok() {
        return $this->hasMany('App\Kelompok');
    }

}
