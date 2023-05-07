<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('jadwal__umums', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('id_instruktur');
            $table->foreign('id_instruktur')->references('id')->on('instrukturs')->onDelete('cascade');
            $table->unsignedBigInteger('id_kelas');
            $table->foreign('id_kelas')->references('id')->on('kelas')->onDelete('cascade');
            $table->string('jam_jadwal_umum')->nullable();
            $table->string('hari_jadwal_umum')->nullable();
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
        Schema::dropIfExists('jadwal__umums');
    }
};
