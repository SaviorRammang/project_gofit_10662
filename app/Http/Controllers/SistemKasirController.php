<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Models\Member;
use App\Models\TransaksiDepositPaket;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SistemKasirController extends Controller
{
    public function memberKadeluarsa()
    {
        $today = Carbon::today();

        $members = Member::where('tanggal_aktivasi_member', '<', $today)
        ->whereNotNull('tanggal_aktivasi_member')
        ->get();
        return response([
            'message'=>'Success Tampil Data',
            'data' => $members
        ],200); 

    }

    public function depositkadeluarsa()
    {
        $today = Carbon::today();

        $members = TransaksiDepositPaket::where('tanggal_kedaluwarsa', '<', $today)
                          ->get();
        return response([
            'message'=>'Success Tampil Data',
            'data' => $members
        ],200); 

    }



    public function memberDeaktivasi()
    {
        $today = Carbon::today();

        $members = Member::where('tanggal_aktivasi_member', '<', $today)
                          ->get();


        foreach ($members as $member) {
        $member->fill([
                'tanggal_aktivasi_member' => null,                // add more attributes to reset to 0 as necessary
                
            ]);
        $member->save();
    }
    return response([
        'message'=>'Success Deaktivasi Member',
        'data' => $members
    ],200); 
    }

    public function resetDeposit()
    {
        $today = Carbon::today();

        $members = TransaksiDepositPaket::where('tanggal_kedaluwarsa', '<', $today)
        ->get();


        foreach ($members as $member) {
        $member->fill([
                'total_deposit_paket' => 0,
                'tanggal_kedaluwarsa' => null,
            ]);
        $member->save();
    }
    return response([
        'message'=>'Success Reset Deposit Member',
        'data' => $members
    ],200); 
    }

    // public function deaktivasiMember(){
    //     $today = Carbon::today();
    //     $member = Member::whereDate('tanggal_aktivasi_member', '<', $today)->update([
    //         'tanggal_aktivasi_member' => '0001-01-01'
    //     ]);

    //     $count = Member::where('tanggal_aktivasi_member', "0001-01-01")->get();

    //     return new MemberResource(true,'Data Berhasil Diubah', $count);
    // }

    // public function getDeactivated(){
    //     $today = Carbon::today();
    //     $formattedDate = $today->format('Y-m-d');
    //     $member = Member::where('tanggal_aktivasi_member', "0001-01-01")
    //     ->whereDate('updated_at', $formattedDate)->get();

    //     return new MemberResource(true,'Data Berhasil Diubah', $member);
    // }

    // public function resetDeposit(){
    //     $today = Carbon::today();
    //     $formattedDate = $today->format('Y-m-d');
    //     $deposit = TransaksiDepositPaket::where('tanggal_kedaluwarsa', '<' , $formattedDate)
    //     ->where('tanggal_kedaluwarsa', '>', '0001-01-01')->update([
    //         'nominal_deposit_paket' => 0,
    //         'tanggal_kedaluwarsa' => '0001-01-01'
    //     ]);

    //     return new MemberResource(true,'Data Berhasil Diubah', $deposit);
    // }

    // public function getResetDeposit(){
    //     $today = Carbon::today();
    //     $formattedDate = $today->format('Y-m-d');
    //     $deposit = TransaksiDepositPaket::where('tanggal_kedaluwarsa', "0001-01-01")
    //     ->where('nominal_deposit_paket', 0)
    //     ->whereDate('updated_at', $formattedDate)->get();

    //     return new MemberResource(true,'Data Berhasil Diubah', $deposit);
    // }

// public function reset()
//     {
//         $reset = PresensiInstruktur::truncate();

//         return new PresensiInstrukturResource(true, 'List Data Presensi Instruktur',
//         $reset);
//     }
}
