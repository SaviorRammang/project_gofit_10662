<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class transak_deposit_uang extends Model
{
    use HasFactory;
    protected $primaryKey = 'no_struk_deposit_uang';
    protected $fillable =[
        'no_struk_deposit_uang',
        'id_member',
        'id_pegawai',
        'id_promo',
        'tanggal_deposit_uang',
        'nominal_deposit_uang',
        'bonus_deposit_uang',
        'total_deposit_uang',
    ];
    
    protected $casts = [
        'no_struk_deposit_uang' => 'string'
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
        return $this->belongsTo(Promo::class, 'id_promo', 'id');

    }

}
