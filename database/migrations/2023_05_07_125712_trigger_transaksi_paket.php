<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::unprepared("
        CREATE TRIGGER `increment_no_struk_deposit_paket` BEFORE INSERT ON `transaksi_deposit_pakets` FOR EACH ROW 
            BEGIN 
            DECLARE last_id INT; 
            DECLARE new_id VARCHAR(255); 
            SET last_id = ( 
                SELECT MAX(RIGHT(no_struk_deposit_paket,3))
                FROM transaksi_deposit_pakets ); 
            IF last_id IS NULL THEN 
                SET new_id = CONCAT(DATE_FORMAT(NOW(), '%y.%m.'), '001'); 
            ELSE 
                SET new_id = CONCAT(DATE_FORMAT(NOW(), '%y.%m.'), LPAD(last_id + 1, 3, '0')); 
            END IF; 
            SET NEW.no_struk_deposit_paket = new_id; 
            END
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER `increment_no_struk_deposit_paket`');
    }
};
