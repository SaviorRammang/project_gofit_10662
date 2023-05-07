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
        Schema::create('instrukturs', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->string('nama_instruktur');
            $table->string('username_instruktur');
            $table->string('email_instruktur')->unique();
            $table->string('password_instruktur');
            $table->string('no_telp_instruktur');
            $table->string('alamat_instruktur');
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
        Schema::dropIfExists('instrukturs');
    }
};
