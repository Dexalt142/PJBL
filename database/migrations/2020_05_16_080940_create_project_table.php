<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProjectTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('project', function (Blueprint $table) {
            $table->id();
            $table->string("nama_project");
            $table->unsignedBigInteger("kelas_id");
            $table->foreign("kelas_id")->references("id")->on("kelas");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('project');
    }
}
