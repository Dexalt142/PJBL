<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKelompokTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('kelompok', function (Blueprint $table) {
            $table->id();
            $table->string("nama_kelompok")->nullable();
            $table->unsignedBigInteger("project_id");
            $table->foreign("project_id")->references("id")->on('project')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('kelompok');
    }
}
