<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FaseKelompok extends Model {
    
    protected $table = 'fase_kelompok';

    protected $fillable = [
        'jawaban', 'jawaban_file', 'status', 'fase_id', 'kelompok_id', 'nilai',
    ];

    public function kelompok() {
        return $this->belongsTo('App\Kelompok');
    }

    public function fase() {
        return $this->belongsTo('App\Fase');
    }

}
