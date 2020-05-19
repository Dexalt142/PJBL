<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Guru extends Model {

    protected $table = 'guru';

    protected $fillable = [
        'nip', 'nama_lengkap', 'tanggal_lahir', 'jenis_kelamin', 'alamat', 'agama', 'user_id',
    ];

    public function kelas() {
        return $this->hasMany('App\Kelas');
    }
}
