<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileMateri extends Model {
    
    protected $table = 'file_materi';

    protected $fillable = [
        'nama_file', 'fase_id'
    ];

    public function fase() {
        return $this->belongsTo('App\Fase');
    }

}
