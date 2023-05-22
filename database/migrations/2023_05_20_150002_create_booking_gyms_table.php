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
        Schema::create('booking_gyms', function (Blueprint $table) {
            $table->string('no_struk_booking_presensi_gym')->primary();
            //foreign key
            $table->string('id_member');
            $table->foreign('id_member')->references('id_member')->on('members')->onDelete('cascade');
            
            $table->date('tanggal_booking_gym')->nullable();
            $table->dateTime('tanggal_yang_di_booking_gym')->nullable();
            $table->string('status_presensi')->nullable();
            $table->boolean('is_canceled')->default(false);
            $table->string('sesi_booking_gym')->nullable();
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
        Schema::dropIfExists('booking_gyms');
    }
};
