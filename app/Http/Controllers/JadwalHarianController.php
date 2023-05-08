<?php

namespace App\Http\Controllers;

use App\Http\Resources\JadwalUmumResource;
use App\Models\JadwalHarian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon; 

class JadwalHarianController extends Controller
{
    public function index()
    {
        $jadwal_harian = JadwalHarian::with(['instruktur','Jadwal_Umum'])->get();
        return new JadwalUmumResource(true, 'Data Jadwal Harian',$jadwal_harian);
    }

    public function store(){
        // cek udah generate atau belum
        $cekJadwalHarian = JadwalHarian::where('tanggal_jadwal_harian', '>', Carbon::now()->startOfWeek(Carbon::SUNDAY)->format('Y-m-d'))->first();
        if(!is_null($cekJadwalHarian)){
            return response()->json([
                'success' => false,
                'message' => 'Jadwal Harian Telah di Generate  ',
                'data' => null
            ]);
        }
        
        //generate
        $start_date = Carbon::now()->startOfWeek(Carbon::SUNDAY)->addDay();
        $end_date = Carbon::now()->startOfWeek(Carbon::SUNDAY)->addDays(7);
        
        //Mapping Hari
        $map = [
            'monday' => 'Senin',
            'tuesday' => 'Selasa',
            'wednesday' => 'Rabu',
            'thursday' => 'Kamis',
            'friday' => 'Jumat',
            'saturday' => 'Sabtu',
            'sunday' => 'Minggu',
        ];
        for($date = $start_date ; $date->lte($end_date);$date->addDay())
        {
            $hari = Carbon::parse($date)->format('l');
            $jadwal_umum = DB::table('jadwal__umums')
            ->where('jadwal__umums.hari_jadwal_umum','=',$map[strtolower($hari)])
            ->get();

            foreach($jadwal_umum as $jd){
                //Agar tidak double
                $jadwal_harian = DB::table('jadwal_harians')
                ->where('tanggal_jadwal_harian','=',$date->toDateString())
                ->where('id_jadwal_umum', '=', $jd->id)
                ->first();
                if(!$jadwal_harian){
                    DB::table('jadwal_harians')->insert([
                        'tanggal_jadwal_harian' =>$date->toDateString(),
                        'status_jadwal_harian' => 'Sedang Berlangsung',
                        'id_jadwal_umum' =>$jd->id,
                        'id_instruktur' =>$jd->id_instruktur,   
                    ]);
                }
            }
        }
        return response([
            'message'=> 'Berhasil Melakukan Generate',
        ]);
    }
    public function update($id_jadwal_harian){
        $jadwal_harian = JadwalHarian::find($id_jadwal_harian);
        $jadwal_harian->status_jadwal_harian = 'DILIBURKAN';
        $jadwal_harian->update();
        return response()->json(['message' => 'Jadwal Harian berhasil diliburkan'], 200);
    }
}
