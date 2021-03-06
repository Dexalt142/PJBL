<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaseKelompokTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('fase_kelompok', function (Blueprint $table) {
            $table->id();
            $table->mediumText("jawaban")->nullable();
            $table->string("jawaban_file")->nullable();
            $table->string("status", 1);
            $table->integer("nilai")->nullable();
            $table->mediumText("evaluasi")->nullable();
            $table->unsignedBigInteger("fase_id");
            $table->unsignedBigInteger("kelompok_id");
            $table->foreign("fase_id")->references("id")->on("fase")->onDelete('cascade');
            $table->foreign("kelompok_id")->references("id")->on("kelompok")->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('fase_kelompok');
    }
}
