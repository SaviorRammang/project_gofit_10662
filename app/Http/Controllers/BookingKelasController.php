<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Models\booking_kelas;
use Illuminate\Http\Request;

class BookingKelasController extends Controller
{
    public function index()
    {
        $booking_kelas = booking_kelas::join('jadwal_harians', 'jadwal_harians.id_jadwal_harian', '=', 'booking_kelas.id_jadwal_harian')
        ->join('jadwal__umums', 'jadwal__umums.id', '=', 'jadwal_harians.id_jadwal_umum')
        ->join('kelas', 'kelas.ID_KELAS', '=', 'jadwal__umums.ID_KELAS')
        ->orderBy('jadwal__umums.jam_jadwal_umum', 'asc')
        ->orderBy('jadwal_harians.tanggal_jadwal_harian', 'asc')
        ->get();

        return new MemberResource(true, 'List Data Booking Presensi Kelas didapatkan!',$booking_kelas);
    }
    
    public function getDataBooking(Request $request)
    {
        $booking_kelas = booking_kelas::join('jadwal_harians', 'jadwal_harians.id_jadwal_harian', '=', 'booking_kelas.id_jadwal_harian')
        ->join('jadwal__umums', 'jadwal__umums.id', '=', 'jadwal_harians.id_jadwal_umum')
        ->join('kelas', 'kelas.id', '=', 'jadwal__umums.id_kelas')
        ->join('members', 'members.id_member', '=', 'booking_kelas.id_member')
        ->orderBy('jadwal__umums.jam_jadwal_umum', 'asc')
        ->orderBy('jadwal_harians.tanggal_jadwal_harian', 'asc')
        ->where('booking_kelas.id_member', $request->id_member)
        ->select('booking_kelas.*', 'jadwal__umums.hari_jadwal_umum', 'jadwal_harians.tanggal_jadwal_harian', 'kelas.nama_kelas', 'members.nama_member')
        ->get();

        return new MemberResource(true, 'List Data Booking Presensi Kelas didapatkan!',$booking_kelas);
    }
}
