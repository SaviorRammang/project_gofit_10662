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
        Schema::create('transaksi_aktivasis', function (Blueprint $table) {
            $table->string('no_struk_transaksi_aktivasi')->primary();
            $table->string('id_member');
            $table->string('id_pegawai');
            $table->date('tanggal_transaksi_aktivasi');
            $table->integer('nominal_transaksi_aktivasi');
            $table->timestamps();
            
            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawais')->onDelete('cascade');
            $table->foreign('id_member')->references('id_member')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaksi_aktivasis');
    }
};
