<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Member extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_member';
    protected $fillable = [
        'id_member',
        'id_user',
        'nama_member',
        'username_member',
        'tanggal_lahir_member',
        'no_telp_member',
        'email_member',
        'password_member',
        'alamat_member',
        'tanggal_aktivasi_member',
        'saldo_deposit_member',
    ]; 
    // public static $rules = [
    //     'nama_member' => "required",
    //     'username_member'=>"required",
    //     'no_telp_member'=>"required",
    //     'email_member' => "required|email:rfc,dns|unique:users",
    //     'password_member' => "required",
    //     'alamat_member'=>"required",
    //     'tanggal_aktivasi_member'=>"required",
    //     'saldo_deposit_member'=>"required",
    // ];

    public function getCreatedAtAttribute() {
        if(!is_null($this->attributes['created_at'])) {
            return Carbon::parse($this->attributes['created_at'])->format('Y-m-d H:i:s');
        }
    }

    public function getUpdatedAtAttribute() {
        if(!is_null($this->attributes['updated_at'])) {
            return Carbon::parse($this->attributes['updated_at'])->format('Y-m-d H:i:s');
        }
    }
    protected $casts = [
        'id_member' => 'string'
    ];
}
