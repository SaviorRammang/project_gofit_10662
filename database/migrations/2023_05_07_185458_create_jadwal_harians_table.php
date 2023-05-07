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
        Schema::create('jadwal_harians', function (Blueprint $table) {
            $table->id('id_jadwal_harian');
            $table->date('tanggal_jadwal_harian');
            //foreign key
            $table->unsignedBigInteger('id_instruktur');
            $table->foreign('id_instruktur')->references('id')->on('instrukturs')->onDelete('cascade');

            //foreign key
            $table->unsignedBigInteger('id_jadwal_umum');
            $table->foreign('id_jadwal_umum')->references('id')->on('jadwal__umums')->onDelete('cascade');

            $table->string('status_jadwal_harian');
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
        Schema::dropIfExists('jadwal_harians');
    }
};
