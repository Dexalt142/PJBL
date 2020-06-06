<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuruTable extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('guru', function (Blueprint $table) {
            $table->id();
            $table->string("nip", 50)->unique();
            $table->string("nama_lengkap");
            $table->date("tanggal_lahir");
            $table->string('jenis_kelamin', 1);
            $table->string("alamat");
            $table->string("agama", 50);
            $table->unsignedBigInteger("user_id")->unique();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('guru');
    }
}
