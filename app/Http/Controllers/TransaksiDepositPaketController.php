<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Models\DepositKelas;
use App\Models\Kelas;
use App\Models\Member;
use App\Models\Pegawai;
use App\Models\Promo;
use App\Models\TransaksiDepositPaket;
use Carbon\Carbon;
use Exception;
use GuzzleHttp\Client;
use Illuminate\Http\Request;

class TransaksiDepositPaketController extends Controller
{
    public function index()
    {
        //get transaksi paket kelas
        $paketKelas =  TransaksiDepositPaket::with(['pegawai','member', 'promo', 'kelas'])->get();
        //render view with posts
        if(count($paketKelas) > 0){
            return new MemberResource(true, 'List Data Transaksi Deposit Paket Kelas',
            $paketKelas); // return data semua transaksi deposit paket kelas dalam bentuk json
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); // return message data transaksi deposit paket kelas kosong
    }

    public function store(Request $request){
        try
        {
            $id_promo = null;
            if($request->id_promo != null){
                $promo = Promo::findorfail($request->id_promo);
                $kelas = Kelas::findorfail($request->id_kelas);
                $member = Member::findorfail($request->id_member);
                $minimal_deposit = $promo->minimal_deposit;
                $nominal_deposit_paket = $request->nominal_deposit_paket;
                $total_deposit_paket_kelas = $request->nominal_deposit_paket;
                if($nominal_deposit_paket >= $minimal_deposit){
                    if($minimal_deposit == 5){
                        $id_promo = $request->id_promo;
                        $id_kelas = $request->id_kelas;
                        $id_member = $request->id_member;
                        $bonus_deposit_paket = $promo->bonus_promo;
                        $tanggal_kedaluwarsa = Carbon::now()->addMonth();
                        $nominal_uang_deposit_paket = $kelas->harga_kelas * $nominal_deposit_paket;
                        $total_deposit_paket_kelas = $total_deposit_paket_kelas + $bonus_deposit_paket;
                    }else if($minimal_deposit == 10){
                        $id_promo = $request->id_promo;
                        $id_kelas = $request->id_kelas;
                        $id_member = $request->id_member;
                        $bonus_deposit_paket = $promo->bonus_promo;
                        $tanggal_kedaluwarsa = Carbon::now()->addMonth()->addMonth();
                        $nominal_uang_deposit_paket = $kelas->harga_kelas * $nominal_deposit_paket;
                        $total_deposit_paket_kelas = $total_deposit_paket_kelas + $bonus_deposit_paket;
                    }
                }else{
                    $id_promo = null;
                    $id_kelas = $request->id_kelas;
                    $id_member = $request->id_member;
                    $bonus_deposit_paket = 0;
                    $tanggal_kedaluwarsa = null;
                    $nominal_deposit_paket = $request->nominal_deposit_paket;
                    $nominal_uang_deposit_paket = $kelas->harga_kelas * $nominal_deposit_paket;
                    $total_deposit_paket_kelas = $nominal_deposit_paket;
                }
            }else{
                $kelas = Kelas::findorfail($request->id_kelas);
                $id_kelas = $request->id_kelas;
                $id_member = $request->id_member;
                $bonus_deposit_paket = 0;
                $tanggal_kedaluwarsa = null;
                $nominal_deposit_paket = $request->nominal_deposit_paket;
                $nominal_uang_deposit_paket = $kelas->harga_kelas * $nominal_deposit_paket;
                $total_deposit_paket_kelas = $nominal_deposit_paket;
            }
            $cek = DepositKelas::where('id_member', $id_member)
            ->where('id_kelas', $id_kelas)
            ->value('deposit_kelas.id');
            if(is_null($cek)){
                $transaksipaketkelas = TransaksiDepositPaket::firstOrCreate([
                    'id_pegawai' => $request->id_pegawai,
                    'id_member'=> $id_member,
                    'id_promo' => $id_promo,
                    'id_kelas' => $id_kelas,
                    'tanggal_deposit_paket' => date('Y-m-d H:i:s', strtotime('now')),
                    'nominal_deposit_paket' => $nominal_deposit_paket,
                    'nominal_uang_deposit_paket' => $nominal_uang_deposit_paket,
                    'bonus_deposit_paket' => $bonus_deposit_paket,
                    'tanggal_kedaluwarsa' => $tanggal_kedaluwarsa,
                    'total_deposit_paket_kelas' => $total_deposit_paket_kelas,
                ]);
                //Update data di tabel member
                //cari data member
                $member = Member::find($request->id_member);
                $pegawai = Pegawai::find($request->id_pegawai);
                // $cekDeposit = DepositKelas::where('id_member', $transaksipaketkelas->id_member)
                // ->where('id_kelas', $transaksipaketkelas->id_kelas)
                // ->value('deposit_kelas.id');
                $deposit = new DepositKelas();
                $deposit->id_member = $transaksipaketkelas->id_member;
                $deposit->id_kelas = $transaksipaketkelas->id_kelas;
                $deposit->sisa_deposit_kelas = $transaksipaketkelas->total_deposit_paket_kelas;
                $deposit->tanggal_kedaluwarsa = $transaksipaketkelas->tanggal_kedaluwarsa;
                $deposit->save();
                return response([
                    'message'=> 'Transaksi Deposit Paket Kelas Berhasil',
                    'data' => ['transaksi_deposit_pakets' => $transaksipaketkelas, 'deposit_kelas' => $deposit, 'sisa_deposit_kelas' => $deposit->sisa_deposit_kelas, 'no_struk_deposit_paket' => TransaksiDepositPaket::latest()->first()->no_struk_deposit_paket, 'nama_member' => $member->nama_member, 'id_member' => $member->id_member, 'nama_pegawai' => $pegawai->nama_pegawai],
                    'total' => $total_deposit_paket_kelas,
                ]);
            }else{
                $depositKelas = DepositKelas::find($cek);
                $sisa = $depositKelas->sisa_deposit_kelas;
                if($sisa == 0){
                    $transaksipaketkelas = TransaksiDepositPaket::firstOrCreate([
                        'id_pegawai' => $request->id_pegawai,
                        'id_member'=> $id_member,
                        'id_promo' => $id_promo,
                        'id_kelas' => $id_kelas,
                        'tanggal_deposit_paket' => date('Y-m-d H:i:s', strtotime('now')),
                        'nominal_deposit_paket' => $nominal_deposit_paket,
                        'nominal_uang_deposit_paket' => $nominal_uang_deposit_paket,
                        'bonus_deposit_paket' => $bonus_deposit_paket,
                        'tanggal_kedaluwarsa' => $tanggal_kedaluwarsa,
                        'total_deposit_paket_kelas' => $total_deposit_paket_kelas,
                    ]);
                    //Update data di tabel member
                    //cari data member
                    $member = Member::find($request->id_member);
                    $pegawai = Pegawai::find($request->id_pegawai);
                    $depositKelas -> update([
                        'sisa_deposit_kelas' => $total_deposit_paket_kelas,
                        'tanggal_kedaluwarsa' => $tanggal_kedaluwarsa
                    ]);
                    
                    return response([
                        'message'=> 'Transaksi Deposit Paket Kelas Berhasil',
                        'data' => ['transaksi_deposit_pakets' => $transaksipaketkelas, 'deposit_kelas' => $depositKelas, 'sisa_deposit_kelas' => $depositKelas->sisa_deposit_kelas, 'no_struk_deposit_paket' => TransaksiDepositPaket::latest()->first()->no_struk_deposit_paket, 'nama_member' => $member->nama_member, 'id_member' => $member->id_member, 'nama_pegawai' => $pegawai->nama_pegawai],
                        'total' => $total_deposit_paket_kelas,
                    ]);
                }else{
                    return response(
                        ['message'=> 'Transaksi Hanya Dapat Dilakukan Jika Sisa Deposit 0',] , 400);
                }
            }

            

        } catch(Exception $e){
            dd($e);
        }
    }
}
