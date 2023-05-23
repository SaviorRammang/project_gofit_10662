<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama_kelas',
        'harga_kelas',
        'kapasitas_kelas',
    ]; 

    public static $rules =[
        'nama_kelas'=>"required",
        'harga_kelas'=>"required",
        'kapasitas_kelas'=>"required",
    ];

}
