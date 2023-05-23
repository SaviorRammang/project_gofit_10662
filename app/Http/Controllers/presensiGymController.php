<?php

namespace App\Http\Controllers;

use App\Models\booking_gym;
use Illuminate\Http\Request;

class presensiGymController extends Controller
{
    public function index()
    {   
        $presensi_gym = booking_gym::where('is_canceled',0)->with(['member'])->latest()->get();
        return response([
            'message' => 'success tampil data',
            'data' => $presensi_gym
        ],200);
    }

    public function update(Request $request, $id)   
    {
        $presensi_gym = booking_gym::find($id);
        $presensi_gym->status_presensi = $request->status_presensi; 
        $presensi_gym->save();
        return response()->json([
            'success' => true,
            'message' => 'Konfirmasi Kehadiran Berhasil dilakukan'
        ],200);
    }

    public function generateStruk($no_struk_booking_presensi_gym, Request $request){
        $dataBooking = booking_gym::with(['member'])->find($no_struk_booking_presensi_gym);

    }
}
