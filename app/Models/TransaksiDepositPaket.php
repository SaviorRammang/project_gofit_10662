<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiDepositPaket extends Model
{
    use HasFactory;
    protected $fillable =[
        'no_struk_deposit_paket ',
        'id_member',
        'id_pegawai',
        'id_promo',
        'id_kelas',
        'tanggal_kedaluwarsa',
        'bonus_deposit_paket',
        'tanggal_deposit_paket',
        'nominal_deposit_paket',
        'nominal_uang_deposit_paket',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member', 'id_member');

    }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');

    }
    public function promo()
    {
        return $this->belongsTo(Promo::class, 'id', 'id_promo');

    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id', 'id_kelas');

    }
}

