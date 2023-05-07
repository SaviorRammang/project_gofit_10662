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
        Schema::create('promos', function (Blueprint $table) {
            $table->id('id');
            $table->string('jenis_promo')->nullable();
            $table->string('nama_promo')->nullable();
            // $table->string('mulai_promo')->nullable();
            $table->string('selesai_promo')->nullable();
            $table->integer('minimal_deposit')->nullable();
            $table->integer('bonus_promo')->nullable();
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
        Schema::dropIfExists('promos');
    }
};
