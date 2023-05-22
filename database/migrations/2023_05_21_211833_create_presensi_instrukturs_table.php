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
        Schema::create('presensi_instrukturs', function (Blueprint $table) {
            $table->id('id_presensi_instruktur');
            //foreign key
            $table->string('id_member');
            $table->foreign('id_member')->references('id_member')->on('members')->onDelete('cascade');
            // foreign key
            $table->unsignedBigInteger('id_jadwal_harian');
            $table->foreign('id_jadwal_harian')->references('id_jadwal_harian')->on('jadwal_harians')->onDelete('cascade');
            // foreign key
            $table->unsignedBigInteger('id_instruktur');
            $table->foreign('id_instruktur')->references('id')->on('instrukturs')->onDelete('cascade');

            $table->time('jam_mulai');
            $table->time('jam_selesai');
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
        Schema::dropIfExists('presensi_instrukturs');
    }
};
