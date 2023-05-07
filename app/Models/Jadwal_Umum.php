<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Jadwal_Umum extends Model
{
    use HasFactory;

    protected $table = 'jadwal__umums';
    protected $fillable = [
        'id_instruktur',
        'id_kelas',
        'hari_jadwal_umum',
        'jam_jadwal_umum'
    ]; 
    
    // public static $rules = [
    //     'hari_jadwal_umum' => 'required',
    //     'id_kelas' => 'required',
    //     'id_instruktur' => 'unique:jadwal_umum,id_instruktur,NULL,id_jadwal_umum,id_instruktur,' . $request->id_instruktur. ',hari_jadwal_umum,' . $request->hari_jadwal_umum . ',jam_jadwal_umum,' .$request->jam_jadwal_umum, ,
    //     'jam_jadwal_umum' => 'required'
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
    public function instruktur()
    {
        return $this->belongsTo(Instruktur::class, 'id_instruktur', 'id');

    }
    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'id_kelas', 'id');

    }
}
