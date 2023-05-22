<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstrukturResource;
use App\Models\IjinInstruktur;
use App\Models\Instruktur;
use App\Models\JadwalHarian;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IjinInstrukturController extends Controller
{

    public function index(){
        $ijin_instruktur = IjinInstruktur::with(['Instruktur','InstrukturPengganti', 'jadwalHarian', 'jadwalHarian.jadwal_umum'])->get();

        return response([
            'message'=>'Success Tampil Data',
            'data' => $ijin_instruktur
        ],200); 
    }
    public function update(Request $request, $id){

        $izin_instruktur = IjinInstruktur::findOrFail($id);
        if($izin_instruktur) {
            $izin_instruktur->status_konfirmasi = $request->status_konfirmasi;
                $izin_instruktur->save();
            return new InstrukturResource(true, 'Data Izin Instruktur Berhasil Diubah!', $izin_instruktur);
        }
        //data instruktur not found
        return new InstrukturResource(false, 'Data Izin Instruktur Tidak Ditemukan!', $izin_instruktur);
    }
    public function store(Request $request)
    {
        $jadwalharian = JadwalHarian::where('id_jadwal_umum', $request->id_jadwal_umum)->first();

        //* Create Jadwal Umum
        $ijin = IjinInstruktur::create([
            // 'hari' => $request->hari,
            'id_jadwal_harian' => $request->id_jadwal_harian,
            'status_ijin' => 'Belum Dikonfirmasi',
            'tanggal_pengajuan' => Carbon::now(),
            'id_instruktur' => $request->id_instruktur,
            'id_instruktur_pengganti' => $request->id_instruktur_pengganti,
            'id_jadwal_harian' => $jadwalharian->id_jadwal_harian
        ]);
        
        //*return response
        return response([
            'message'=> 'success tambah data ijin',
            'data' => $ijin,
        ]);

    }
}
