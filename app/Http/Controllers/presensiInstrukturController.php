<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstrukturResource;
use App\Models\Instruktur;
use App\Models\JadwalHarian;
use App\Models\presensiInstruktur;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class presensiInstrukturController extends Controller
{
    public function index()
    {
        //get presensi instruktur
        $presensi =  presensiInstruktur::with(['instruktur', 'jadwalharian'])->get();
        //render view with posts
        if(count($presensi) > 0){
            return new InstrukturResource(true, 'List Data Presensi Instruktur',
            $presensi); // return data semua presensi instruktur dalam bentuk json
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); // return message data presensi instruktur kosong
    }

    public function createPresensiInstruktur()
    {
        // Retrieve all JadwalHarian records
        $jadwalHarians = JadwalHarian::all();
        if($jadwalHarians == null){
            return response()->json(['message' => 'Jadwal Harian Belum Digenerate']);
        }else{
            foreach ($jadwalHarians as $jadwalHarian) {
                // Create new PresensiInstruktur record
               $presensi = PresensiInstruktur::create([
                    'id_instruktur' => $jadwalHarian->id_instruktur,
                    'id_jadwal_harian' => $jadwalHarian->id,
                    'jam_mulai' => null, 
                    'jam_selesai' => null, 
                ]);
            }
    
            return response()->json(['message' => 'Berhasil Melakukan Generate Presensi Instruktur']);
        }
    }

    public function update(Request $request, $id){
        $presensi = PresensiInstruktur::find($id);

        $instruktur = Instruktur::find($presensi->id_instruktur);
        $id_jadwal_harian = JadwalHarian::where('id', $presensi->id_jadwal_harian)
            ->value('jadwal_harians.id');
        $harians = JadwalHarian::find($presensi->id_jadwal_harian);
        $takejam = JadwalHarian::join('jadwal__umums', 'jadwal_harians.id_jadwal_umum', '=', 'jadwal__umums.id')
            ->where('jadwal_harians.id', $id_jadwal_harian)
            ->value('jadwal__umums.jam_jadwal_umum');

        if($presensi->jam_mulai == null){
            $format = 'H:i';
            try {
                $time = Carbon::createFromFormat($format, $takejam);
            } catch (\Exception $e) {
                // Handle error: Invalid time format
                return response()->json(['error' => 'Invalid time format'], 422);
            }

            // $jam_mulai = $request->jam_mulai;
            $jam_mulai = Carbon::createFromFormat($format, $request->jam_mulai);
            $validator = Validator::make($request->all(), [
                'jam_mulai' => 'required',
                ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $presensi->update([
                'jam_mulai' => $request->jam_mulai,
            ]);

            if($jam_mulai->greaterThan($time)){
                $telat = $instruktur->jumlah_keterlambatan_instruktur + 1;
                $instruktur->jumlah_keterlambatan_instruktur = $telat;
                $instruktur->save();
            }
        }else{
            $validator = Validator::make($request->all(), [
                'jam_selesai' => 'required',
                'status_presensi' => 'required',
                ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $presensi->update([
                'jam_selesai' => $request->jam_selesai,
                'status_presensi' => $request->status_presensi, 
            ]);
        }

        return new InstrukturResource(true, 'Data Presensi Berhasil Diupdate!', $presensi);
    }
}
