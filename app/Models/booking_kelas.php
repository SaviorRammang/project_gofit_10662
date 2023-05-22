<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class booking_kelas extends Model
{
    use HasFactory;
    protected $fillable = [
        'no_struk_booking_presensi_kelas',
        'id_jadwal_harian',
        'id_member',
        'tanggal_booking_kelas',
        'status_presensi',
        'is_canceled',
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
