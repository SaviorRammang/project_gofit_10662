<?php

namespace App\Http\Controllers;

use App\Models\Member;
use Illuminate\Http\Request;
use App\Models\TransaksiAktivasi;
use Illuminate\Support\Facades\Validator;
use Haruncpi\LaravelIdGenerator\IdGenerator;

class TransaksiAktivasiController extends Controller
{
    public function store(Request $request)
    {
        $transaksi_member = TransaksiAktivasi::create([
            'tanggal_transaksi_aktivasi' => date('Y-m-d', strtotime('now')),
            'id_member' => $request->id_member,
            'id_pegawai' => $request->id_pegawai,
            'nominal_transaksi_aktivasi' => '3000000'
        ]);
        $member = Member::where('id_member', $request->id_member)->first();
        if ($member->tanggal_aktivasi_member == null) {
            $tgl_aktivasi = date('Y-m-d H:i:s'); // jika kosong, gunakan tanggal hari ini
        } else {
            $tgl_aktivasi = $member->tanggal_aktivasi_member; // gunakan tanggal aktivasi yang ada di database
        }
        $tgl_kadaluarsa = date('Y-m-d H:i:s', strtotime('+1 year', strtotime($tgl_aktivasi)));
        $member->tanggal_aktivasi_member = $tgl_kadaluarsa;
        $member->save();
        
        return response([
            'message'=> 'success tambah data transaksi aktivasi',
            'data' => ['transaksi_member' => $transaksi_member, 'member' => $member, 'no_struk' => TransaksiAktivasi::latest()->first()->no_struk_transaksi_aktivasi],
        ]);
        
    }
}
