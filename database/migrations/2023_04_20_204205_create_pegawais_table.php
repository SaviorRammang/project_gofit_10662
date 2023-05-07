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
        Schema::create('pegawais', function (Blueprint $table) {
            $table->string('id_pegawai') ->primary();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->string('nama_pegawai');
            // $table->string('username_pegawai');
            $table->string('no_telp_pegawai');
            // $table->string('email_pegawai')->unique();
            // $table->string('password_pegawai');
            $table->string('alamat_pegawai');
            $table->enum('jabatan_pegawai',['admin','kasir','mo'])->default('kasir');
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
        Schema::dropIfExists('pegawais');
    }
};
