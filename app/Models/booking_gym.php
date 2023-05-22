<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class booking_gym extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_struk_booking_presensi_gym',
        'id_member',
        'tanggal_booking_gym',
        'tanggal_yang_di_booking_gym',
        'status_presensi',
        'is_canceled',
        'sesi_booking_gym',
    ];

    public function getCreatedAtAttribute(){
        if(!is_null($this->attributes['created_at'])){
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdatedAtAttribute(){
        if(!is_null($this->attributes['updated_at'])){
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    }
    public function member(){
        return $this->belongsTo(Member::class, 'id_member', 'id_member');
    }
}
