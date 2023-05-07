<?php

namespace App\Http\Controllers;

use App\Http\Resources\JadwalUmumResource;
use App\Models\Jadwal_Harian;
use App\Models\JadwalHarian;
use Illuminate\Http\Request;

class JadwalHarianController extends Controller
{
    public function index()
    {
        $jadwal_harian = JadwalHarian::with(['instruktur','Jadwal_Umum'])->get();
        return new JadwalUmumResource(true, 'Data Jadwal Harian',$jadwal_harian);
    }
    public function store(){

    }
}
