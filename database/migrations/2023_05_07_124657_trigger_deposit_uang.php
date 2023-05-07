<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
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
        DB::unprepared("
        CREATE TRIGGER `increment_no_struk_deposit_uang` BEFORE INSERT ON `transak_deposit_uangs` FOR EACH ROW 
            BEGIN 
            DECLARE last_id INT; 
            DECLARE new_id VARCHAR(255); 
            SET last_id = ( 
                SELECT MAX(RIGHT(no_struk_deposit_uang,3))
                FROM transak_deposit_uangs ); 
            IF last_id IS NULL THEN 
                SET new_id = CONCAT(DATE_FORMAT(NOW(), '%y.%m.'), '001'); 
            ELSE 
                SET new_id = CONCAT(DATE_FORMAT(NOW(), '%y.%m.'), LPAD(last_id + 1, 3, '0')); 
            END IF; 
            SET NEW.no_struk_deposit_uang = new_id; 
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
        DB::unprepared('DROP TRIGGER `increment_no_struk_deposit_uang`');
    }
};
