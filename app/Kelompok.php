<?php

namespace App;

use App\Siswa;
use App\FaseKelompok;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class Kelompok extends Model {

    protected $table = 'kelompok';

    protected $fillable = [
        'nama_kelompok', 'project_id'
    ];

    public function anggota() {
        $anggota = new Collection;
        $siswaList = DB::table('kelompok_anggota')->where('kelompok_id', $this->id)->get('siswa_id');
        foreach ($siswaList as $siswa) {
            $s = DB::table('kelas_siswa')->where('id', $siswa->siswa_id)->first();
            $anggota->push(Siswa::find($s->siswa_id));
        }
        return $anggota;
    }

    public function fase() {
        return $this->belongsToMany('App\Fase')->withPivot('jawaban', 'jawaban_file', 'status', 'id', 'nilai');
    }

    public function faseProgress($fase_id) {
        return FaseKelompok::where(['fase_id' => $fase_id, 'kelompok_id' => $this->id])->first();
    }

}
