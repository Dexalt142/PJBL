<?php

namespace App;

use App\Siswa;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

class Kelompok extends Model {

    protected $table = 'kelompok';

    protected $fillable = [
        'jumlah_anggota'
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
}
