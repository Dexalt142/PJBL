<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFaseTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('fase', function (Blueprint $table) {
            $table->id();
            $table->string("nama_fase");
            $table->mediumText("deskripsi");
            $table->dateTime("deadline");
            $table->string("fase_type", 50);
            $table->string("fase_ke", 5);
            $table->unsignedBigInteger("project_id");
            $table->foreign("project_id")->references("id")->on("project");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('fase');
    }
}
