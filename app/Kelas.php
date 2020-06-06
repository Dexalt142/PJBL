<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model {

    protected $table = 'kelas';
    
    protected $fillable = [
        'kode_kelas', 'nama', 'kode_undangan', 'guru_id',
    ];

    public function guru() {
        return $this->belongsTo('App\Guru');
    }

    public function siswa() {
        return $this->belongsToMany('App\Siswa')->withPivot('id');
    }

    public function project() {
        return $this->hasMany('App\Project');
    }

}
