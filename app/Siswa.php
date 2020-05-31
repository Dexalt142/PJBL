<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

class Siswa extends Model {

    protected $table = 'siswa';

    protected $fillable = [
        'nis', 'nama_lengkap', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'agama', 'user_id',
    ];

    public function kelas() {
        return $this->belongsToMany('App\Kelas');
    }

    public function project() {
        $project = new Collection;
        foreach($this->kelas as $kelas) {
            $project = $project->merge($kelas->project);
        }

        return $project;
    }



}
