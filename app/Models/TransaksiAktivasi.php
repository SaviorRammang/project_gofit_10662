<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransaksiAktivasi extends Model
{
    use HasFactory;
    protected $fillable =[
        'no_struk_transaksi_aktivasi',
        'id_member',
        'id_pegawai',
        'tanggal_transaksi_aktivasi',
        'nominal_transaksi_aktivasi',
    ];

    public function member()
    {
        return $this->belongsTo(Member::class, 'id_member', 'id_member');

    }
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'id_pegawai', 'id_pegawai');

    }
}
