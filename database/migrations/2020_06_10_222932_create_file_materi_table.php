<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFileMateriTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('file_materi', function (Blueprint $table) {
            $table->id();
            $table->string('nama_file');
            $table->unsignedBigInteger('fase_id');
            $table->foreign('fase_id')->references('id')->on('fase')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('file_materi');
    }
}
