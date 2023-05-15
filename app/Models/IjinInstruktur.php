<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IjinInstruktur extends Model
{
    use HasFactory;
    
    protected $primaryKey  = "ijin_instruktur";
    protected $fillable = [
        'id_instruktur',
        'id_instruktur_pengganti',
        'id_jadwal_harian',
        'hari_izin',
        'tanggal_pengajuan_izin',
        'tanggal_izin',
        'jam_sesi_izin',
        'keterangan_izin',
        'status_konfirmasi',
    ]; 

    public function Instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'id_instruktur', 'id');

    }
    public function InstrukturPengganti()
    {
        return $this->belongsTo(Instruktur::class, 'id_instruktur_pengganti', 'id');

    }
    public function jadwalHarian()
    {
        return $this->belongsTo(JadwalHarian::class, 'id_jadwal_harian', 'id_jadwal_harian');

    }

}
