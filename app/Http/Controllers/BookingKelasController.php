<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Models\booking_kelas;
use Illuminate\Http\Request;

class BookingKelasController extends Controller
{
    public function index()
    {
        //get booking kelas
        $bookkelas =  booking_kelas::with(['jadwalharian','member', 'depositkelas'])->get();
        //render view with posts
        if(count($bookkelas) > 0){
            return new MemberResource(true, 'List Data Booking Kelas',$bookkelas); // return data semua booking kelas dalam bentuk json
        }

        return response([
            'message' => 'Empty',
            'data' => null
        ], 400); // return message data booking kelas kosong
    }
}
