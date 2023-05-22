<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Models\DepositKelas;
use Illuminate\Http\Request;

class DepositKelasController extends Controller
{
    public function index()
    {
        //get deposit kelas
        $depositkelas =  DepositKelas::with(['member','kelas'])->get();
        //render view with posts
        if(count($depositkelas) > 0){
            return new MemberResource(true, 'List Data Deposit Kelas',
            $depositkelas); // return data semua deposit kelas dalam bentuk json
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); // return message data deposit kelas kosong

    }
    
    public function store(Request $request){
        $depositkelas = DepositKelas::create([ 
            'id_member' => $request->id_member,
            'id_kelas' => $request->id_kelas, 
            'sisa_deposit_kelas' => $request->sisa_deposit_kelas,
            'masa_berlaku_deposit_kelas' => $request->masa_berlaku_deposit_kelas,
        ]);

        return new MemberResource(true, 'Data Deposit Kelas Berhasil Ditambahkan!', $depositkelas);
    }

    public function destroy($id)
    {
        $depositkelas= DepositKelas::find($id);

        if(is_null($depositkelas)){
            return response([
                'message' => 'Deposit Kelas Tidak Ditemukan',
                'data' => null
            ], 404);
        }

        if($depositkelas->delete()){
            return response([
                'message' =>'Delete Deposit Sukses',
                'data' => $depositkelas
            ], 200);
        }
        return response([
            'message' => 'Delete Deposit Gagal',
            'data' => null
        ], 400);
    }
}
