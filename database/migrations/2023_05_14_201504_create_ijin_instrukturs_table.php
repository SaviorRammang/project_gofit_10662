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
        Schema::create('ijin_instrukturs', function (Blueprint $table) {
            $table->id('ijin_instruktur');

            //foreign key instruktur
            $table->unsignedBigInteger('id_instruktur');
            $table->foreign('id_instruktur')->references('id')->on('instrukturs')->onDelete('cascade');
            //foreign key id instruktur pengganti
            $table->unsignedBigInteger('id_instruktur_pengganti');
            $table->foreign('id_instruktur_pengganti')->references('id')->on('instrukturs')->onDelete('cascade');

            $table->string('hari_izin');
            $table->date('tanggal_pengajuan_izin');
            $table->date('tanggal_izin');
            $table->time('jam_sesi_izin');
            $table->string('keterangan_izin');
            $table->string('status_konfirmasi');

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
        Schema::dropIfExists('ijin_instrukturs');
    }
};
