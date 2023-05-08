<?php

namespace App\Http\Controllers;

use App\Models\Promo;
use App\Models\Member;
use App\Models\transak_deposit_uang;
use Exception;
use Illuminate\Http\Request;

class TransaksiDepositUangController extends Controller
{
    //Create   No Transaksi (Trigger | Logic di Laravel)
    public function store(Request $request)
    {
        if($request->nominal_deposit_uang <= 500000 ){
            return response(
                ['message'=> 'Transaksi Gagal, Minimal Deposit Rp 500.000',] , 400);
        }
        try
        {
            $id_promo = null;
            if($request->id_promo != null){
                $promo = Promo::findorfail($request->id_promo);
                $minimal_deposit = $promo->minimal_deposit;
                $nominal_deposit_uang = $request->nominal_deposit_uang;
                $total_deposit_uang = $request->nominal_deposit_uang;
                if($minimal_deposit <= $nominal_deposit_uang){
                    $id_promo = $request->id_promo;
                    $bonus_deposit_uang = $promo->bonus_promo;
                    $total_deposit_uang += $promo->bonus_promo;
                }else{
                    $id_promo = null;
                    $bonus_deposit_uang = 0;
                    $total_deposit_uang = $nominal_deposit_uang;
                }
                
            }else{
                $nominal_deposit_uang = $request->nominal_deposit_uang;
                $bonus_deposit_uang = 0;
                $total_deposit_uang = $nominal_deposit_uang;
            }

            $depositUang = transak_deposit_uang::firstOrCreate  ([
                'tanggal_deposit_uang' => date('Y-m-d H:i:s', strtotime('now')),
                'nominal_deposit_uang' => $nominal_deposit_uang,
                'bonus_deposit_uang' => $bonus_deposit_uang,
                'total_deposit_uang' =>   $total_deposit_uang,
                'id_pegawai' => $request->id_pegawai,
                'id_member'=> $request->id_member,
                'id_promo' => $id_promo,
                'no_struk_deposit_uang' => '' 
                // 'no_struk' => $transa['no_struk_transaksi']
            ]);
            //Update data di tabel member
            //cari data member
            $member = Member::find($request->id_member);
            $sebelum_transaksi = $member->saldo_deposit_member;
            $member->saldo_deposit_member =  $sebelum_transaksi + $total_deposit_uang;
            $member->save();
            return response([
                'message'=> 'Berhasil Melakukan Transaksi',
                'data' => ['transaksi_deposit_uang' => $depositUang, 'sisa_deposit' => $sebelum_transaksi, 'no_struk' => transak_deposit_uang::latest()->first()->no_struk_deposit_uang, 'siganteng' => $member->nama_member],
                'total' => $total_deposit_uang,
            ]);

        } catch(Exception $e){
            dd($e);
        }
        
    }
    //Create Deposit Reguler    
}
