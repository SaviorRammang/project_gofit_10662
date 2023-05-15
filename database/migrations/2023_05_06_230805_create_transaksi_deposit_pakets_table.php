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
        Schema::create('transaksi_deposit_pakets', function (Blueprint $table) {
            $table->string('no_struk_deposit_paket')->primary();
            //foreign key promo
            $table->unsignedBigInteger('id_promo');
            $table->foreign('id_promo')->references('id')->on('promos')->onDelete('cascade');
            // foreign kelas
            $table->unsignedBigInteger('id_kelas');
            $table->foreign('id_kelas')->references('id')->on('kelas')->onDelete('cascade');
            //foreign member
            $table->string('id_member');
            $table->foreign('id_member')->references('id_member')->on('members')->onDelete('cascade');
            // foreign pegawai
            $table->string('id_pegawai');
            $table->foreign('id_pegawai')->references('id_pegawai')->on('pegawais')->onDelete('cascade');
            //
            $table->date('tanggal_kedaluwarsa');
            $table->integer('bonus_deposit_paket');
            $table->date('tanggal_deposit_paket');
            $table->integer('nominal_deposit_paket');
            $table->integer('nominal_uang_deposit_paket');
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
        Schema::dropIfExists('transaksi_deposit_pakets');
    }
};
