<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelompokAnggotaTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('kelompok_anggota', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("kelompok_id");
            $table->unsignedBigInteger("siswa_id");
            $table->foreign("kelompok_id")->references("id")->on("kelompok")->onDelete('cascade');
            $table->foreign("siswa_id")->references("id")->on("kelas_siswa")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('kelompok_anggota');
    }
}
