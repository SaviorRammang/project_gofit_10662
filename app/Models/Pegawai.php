<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Pegawai extends Model
{
    use HasFactory;

    protected $fillable =[
        'nama_pegawai',
        'username_pegawai',
        'no_telp_pegawai',
        'email_pegawai',
        'password_pegawai',
        'alamat_pegawai',
        'jabatan_pegawai'
    ];
    public static $rules = [
        'nama_pegawai' => "required",
        'username_pegawai' => "required",
        'no_telp_pegawai' => "required",
        'email_pegawai' => "required|email",
        'password_pegawai'=>"required",
        'alamat_pegawai'=>"required",
        'jabatan_pegawai'=>"required"
    ];

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
}
