<?php

namespace App\Http\Controllers;

use App\Models\booking_gym;
use App\Models\Member;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;

class BookingGymConctroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     //* Fungsi sebelum store


    public function cekNotKadeluarsa($id){
        $member = Member::find($id);
        if($member->tanggal_aktivasi_member == null || $member->tanggal_aktivasi_member < Carbon::now() ){
            return false;
        }
        return true;
    }


    public function cekKuotaIsFull($tanggalYangDiBooking ){
        $daftarBooking = booking_gym::where('tanggal_yang_di_booking_gym', $tanggalYangDiBooking )->count();
        // $request->tanggal_yang_di_booking_gym
        if($daftarBooking < 10 ){
            return true;
        }
        return false;
    }

    public function cekBookingSame($tanggalYangDiBooking , $idMember){
        $daftarBooking = booking_gym::where('tanggal_yang_di_booking_gym', $tanggalYangDiBooking,)->where('id_member',$idMember)->count();
        if($daftarBooking == 0 ){
            //* tidak ada yang sama
            return false;
        }
        //* ada yang sama
        return true;
    }



    public function store(Request $request)
    {
        //* Cek Status Aktif Member
        if(!self::cekNotKadeluarsa($request->id_member)){
            return Response(['message' => 'Akun Anda Sudah Kadeluarsa'],400);
        }
        //* Cek  Kuota
        if(!self::cekKuotaIsFull($request->tanggal_yang_di_booking_gym , $request->id_sesi)){
            return Response(['message' => 'Kuota Telah Penuh'],400);
        }
        // self::cekBookingSame(Carbon::today(),1,$request->id_member);
        //* Cek Apakah Member sudah pernah melakukan booking pada hari yang sama
        //* Cek Apakah Booking Sama
        if(self::cekBookingSame($request->tanggal_yang_di_booking_gym,$request->id_sesi,$request->id_member)){
            return Response(['message' => 'Anda Telah Melakuakn Booking pada sesi dan tanggal ini'],400);
        }
        //* Apakah Member melakukan Booking pada Hari yang sama (Sama kayak diatas tp tidak perlu sesi)
        try{
            $booking = booking_gym::create([
                'id_member' => $request->id_member,
                'tanggal_booking_gym' => Carbon::now(),
                'tanggal_yang_di_booking_gym' => $request->tanggal_yang_di_booking_gym,
                'sesi_booking_gym' => $request->sesi_booking_gym,
            ]);
            
            return response([
                'message' => 'Berhasil Booking',
                'data' => $booking]);
        }catch(Exception $e){
            dd($e);
        }   
    }

    //Show Data
    public function showData(Request $request){
        $bookingGym = booking_gym::where('id_member', $request->id_member)->where('is_canceled', 0)->get();

        return(response(['data' => $bookingGym]));
    }

    //Cancel Booking
    public function cancelBookingGym($no_struk_booking_presensi_gym ){
        //* Cari Data yang sesuai dengan nomor Booking
        $bookingGym = booking_gym::find($no_struk_booking_presensi_gym );
        //* Cek minimal cancel h-1 Tanggal_Sesi_Gym - 1 
        $today = Carbon::today();
        $batasCancel = Carbon::parse($bookingGym->tanggal_yang_di_booking_gym)->subDay();
        if($batasCancel->greaterThanOrEqualTo($today)){
            
            $bookingGym->is_canceled =  1;
            $bookingGym->update();
            //* Response
            return response(
                [
                    'message' => 'Berhasil Membatalkan',
                    'data' => $bookingGym
                ]);
        }else{
            return response(['message' => 'Tidak bisa membatalkan, maksimal pembatalan H-1'],400);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
