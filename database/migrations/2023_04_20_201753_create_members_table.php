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
        Schema::create('members', function (Blueprint $table) {
            $table->string('id_member') ->primary();
            $table->unsignedBigInteger('id_user');
            $table->foreign('id_user')->references('id')->on('users')->onDelete('cascade');
            $table->string('nama_member');
            $table->string('username_member');
            $table->string('tanggal_lahir_member');
            $table->string('no_telp_member');
            $table->string('email_member')->unique();
            $table->string('password_member');
            $table->string('alamat_member');
            $table->string('tanggal_aktivasi_member');
            $table->integer('saldo_deposit_member');
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
        Schema::dropIfExists('members');
    }
};
