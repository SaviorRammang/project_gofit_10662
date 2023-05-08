<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JadwalHarian extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_jadwal_harian';
    protected $fillable = [
        'id_instruktur',
        'id_jadwal_umum',
        'tanggal_jadwal_harian',
        'status_jadwal_harian'
    ]; 

    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'id_instruktur', 'id');

    }
    public function jadwal_umum()
    {
        return $this->belongsTo(Jadwal_Umum::class, 'id_jadwal_umum', 'id');

    }
}
