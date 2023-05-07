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
        Schema::create('transak_deposit_uangs', function (Blueprint $table) {
            $table->string('no_struk_deposit_uang')->primary();
            $table->string('id_pegawai');
            $table->string('id_member');
            // $table->string('id_promo');
            $table->unsignedBigInteger('id_promo');
            $table->foreign('id_promo')->references('id')->on('promos')->onDelete('cascade');
            $table->dateTime('tanggal_deposit_uang');
            $table->integer('nominal_deposit_uang');
            $table->integer('bonus_deposit_uang');
            $table->integer('total_deposit_uang');
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
        Schema::dropIfExists('transak_deposit_uangs');
    }
};
