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
        Schema::create('booking_kelas', function (Blueprint $table) {
            $table->string('no_struk_booking_presensi_kelas')->primary();
            //foreign key
            $table->string('id_member');
            $table->foreign('id_member')->references('id_member')->on('members')->onDelete('cascade');
            //foreign key
            $table->unsignedBigInteger('id_jadwal_harian');
            $table->foreign('id_jadwal_harian')->references('id_jadwal_harian')->on('jadwal_harians')->onDelete('cascade');

            //foreign key
            $table->unsignedBigInteger('id_deposit_kelas')->nullable();
            $table->foreign('id_deposit_kelas')->references('id')->on('deposit_kelas')->onDelete('cascade');

            $table->boolean('is_canceled')->default(false);
            $table->string('status_presensi')->nullable();
            $table->dateTime('tanggal_booking_kelas')->nullable();
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
        Schema::dropIfExists('booking_kelas');
    }
};
