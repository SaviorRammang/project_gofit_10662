<?php

namespace App\Http\Controllers;

use App\Http\Resources\JadwalUmumResource;
use App\Models\Instruktur;
use App\Models\Jadwal_Umum;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;


class JadwalUmumController extends Controller
{
    /**
    * index
    *
    * @return void
    */
    public function index()
    {
        $jadwal_umum = Jadwal_Umum::with(['instruktur','kelas'])->get();

        return new JadwalUmumResource(true, 'Data Jadwal',$jadwal_umum);
        // return view('jadwalUmum.index', compact('jadwal_umum'));
    }

    /**
    * create
    *
    * @return void
    */
    public function create()
    {
        $kelas = Kelas::all();
        $instruktur = Instruktur::all();
        $jadwal_umum = Jadwal_Umum::all();
        return view('jadwalUmum.create', compact('kelas', 'instruktur', 'jadwal_umum'));

    }
    /**
    * store
    *
    * @param Request $request
    * @return void
    */
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'hari_jadwal_umum' => 'required',
            'id_kelas' => 'required',
            'id_instruktur' => 'unique:jadwal__umums,id_instruktur,NULL,id_jadwal_umum,id_instruktur,' . $request->id_instruktur. ',hari_jadwal_umum,' . $request->hari_jadwal_umum . ',jam_jadwal_umum,' .$request->jam_jadwal_umum,
            'jam_jadwal_umum' => 'required'
        ],
        [   'id_instruktur.required' => 'Tidak Boleh Kosong!',
            'id_instruktur.unique' => 'Jadwal Instruktur Bertabrakan!']);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
         //Fungsi Simpan Data ke dalam Database
         $jadwal_umum = Jadwal_Umum::create([
            'hari_jadwal_umum' => $request->hari_jadwal_umum,
            'id_kelas' => $request->id_kelas,
            'id_instruktur' => $request->id_instruktur,
            'jam_jadwal_umum' => $request->jam_jadwal_umum
        ]);

        return new JadwalUmumResource(true, 'Data Jadwal Umum Berhasil Ditambahkan!', $jadwal_umum);
    }

     /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $jadwal = Jadwal_Umum::findOrfail($id);

        if($jadwal) {

            //delete team
            $jadwal->delete();

            return new JadwalUmumResource(true, 'Data Jadwal Dihapus!', $jadwal);

        }

        //data team not found
        return new JadwalUmumResource(false, 'Data Jadwal Tidak Ditemukan!', $jadwal);
    }

    public function edit($id)
    {
        $jadwal_umum = Jadwal_Umum::findOrFail($id);
        $kelas = Kelas::all();
        $instruktur = Instruktur::all();
        return view('jadwalUmum.edit', compact('jadwal_umum', 'kelas', 'instruktur'));
    }


     /** update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */
    public function update(Request $request, $id)
    {
         //Validasi Formulir
         $validator = Validator::make($request->all(), [
            'hari_jadwal_umum' => 'required',
            'id_kelas' => 'required',
            'id_instruktur' => 'unique:jadwal__umums,id_instruktur,NULL,id,id_instruktur,' . $request->id_instruktur. ',hari_jadwal_umum,' . $request->hari_jadwal_umum . ',jam_jadwal_umum,' .$request->jam_jadwal_umum,
            'jam_jadwal_umum' => 'required'
        ],
        [   'id_instruktur.required' => 'Tidak Boleh Kosong!',
            'id_instruktur.unique' => 'Jadwal Instruktur Bertabrakan!']);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //Fungsi Simpan Data ke dalam Database
        $jadwal_umum = Jadwal_Umum::where('id', $id)->update([
            'hari_jadwal_umum' => $request->hari_jadwal_umum,
            'id_kelas' => $request->id_kelas,
            'id_instruktur' => $request->id_instruktur,
            'jam_jadwal_umum' => $request->jam_jadwal_umum
        ]);

        // alihkan halaman ke halaman jadwal_umum
        return new JadwalUmumResource(true, 'Data Jadwal Umum berhasil diubah!', $jadwal_umum);
    }



    public function messages()
    {
        return [
            'id_instruktur.unique' => 'Jadwal Instruktur Bertabrakan!'
        ];
    }

    public function getJadwalMobile(){
        $jadwal = Jadwal_Umum::orderByRaw("FIELD(hari_jadwal_umum, 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu')")->with(['instruktur','kelas'])->get();
        // $sortedData = DB::table('jadwal_umum')
            // ->orderByRaw("FIELD(hari, 'senin', 'selasa', 'rabu', 'kamis', 'jumat', 'sabtu', 'minggu')")
            // ->get();

        return response(['data'=>$jadwal]);

    }
}

