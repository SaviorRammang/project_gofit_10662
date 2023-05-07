<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Promo extends Model
{
    use HasFactory;
    protected $fillable = [
        'jenis_promo',
        'nama_promo',
        'selesai_promo',
        'minimal_deposit',
        'bonus_promo',
    ];  
    public static $rules = [
        'jenis_promo'=> "required",
        'nama_promo' => "nama_promo",
        // 'mulai_promo'=> "required",
        'selesai_promo'=> "required",
        'minimal_deposit'=> "required",
        'bonus_promo'=> "required",
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
