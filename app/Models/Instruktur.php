<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Instruktur extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'nama_instruktur',
        'username_instruktur',
        'email_instruktur',
        'password_instruktur',
        'no_telp_instruktur',
        'alamat_instruktur'
    ]; 

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id');

    }

    // public static $rules = [
    //     'nama_instruktur'=> "required",
    //     'username_instruktur'=> "required",
    //     'email_instruktur'=> "required|email:rfc,dns|unique:users",
    //     'password_instruktur'=> "required",
    //     'no_telp_instruktur'=> "required",
    //     'alamat_instruktur'=> "required"
    // ];
}
