<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelasTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string("kode_kelas", 50)->unique();
            $table->string("nama");
            $table->string("kode_undangan", 50)->unique();
            $table->unsignedBigInteger("guru_id")->unique();
            $table->foreign("guru_id")->references("id")->on("guru");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('kelas');
    }
}
