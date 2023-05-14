<?php

namespace App\Http\Controllers;

use App\Http\Resources\InstrukturResource;
use App\Models\IjinInstruktur;
use App\Models\Instruktur;
use Illuminate\Http\Request;

class IjinInstrukturController extends Controller
{

    public function index(Request $request){
        $ijin_instruktur = IjinInstruktur::with(['Instruktur','InstrukturPengganti'])->get();

        return response([
            'message'=>'Success Tampil Data',
            'data' => $ijin_instruktur
        ],200); 
    }
    public function update(Request $request, $id){

        $izin_instruktur = IjinInstruktur::findOrFail($id);
        //

        if($izin_instruktur) {

            //izin_instruktur post 
            // $izin_instruktur->update([
            // ]);
            $izin_instruktur->status_konfirmasi = $request->status_konfirmasi;
            $izin_instruktur->save();

            return new InstrukturResource(true, 'Data Izin Instruktur Berhasil Diubah!', $izin_instruktur);

        }

        //data instruktur not found
        return new InstrukturResource(false, 'Data Izin Instruktur Tidak Ditemukan!', $izin_instruktur);
    }
}
