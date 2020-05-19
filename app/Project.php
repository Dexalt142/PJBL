<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model {
    
    protected $table = 'project';

    protected $fillable = [
        'nama_project', 'kelas_id',
    ];

}
