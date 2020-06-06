<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasSiswaTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('kelas_siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("kelas_id");
            $table->unsignedBigInteger("siswa_id");
            $table->foreign("kelas_id")->references("id")->on("kelas")->onDelete('cascade');
            $table->foreign("siswa_id")->references("id")->on("siswa")->onDelete('cascade');
            $table->datetime("tanggal_masuk");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelas_siswa');
    }
}
