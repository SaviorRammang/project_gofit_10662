<?php

namespace App\Http\Controllers;

use App\Models\booking_gym;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LaporanController extends Controller
{
    public function kinerjaInstrukturBulanan(Request $request)    {
        $bulan = Carbon::now()->month;
        if ($request->has('month') && !empty($request->month)) {
            $bulan = $request->month;
        }
        // dd($bulan);
        //* Tanggal Cetak
        $tanggalCetak = Carbon::now();
        $kinerjaInstruktur = DB::select('
        SELECT i.nama_instruktur,
            SUM(CASE WHEN pi.id_presensi_instruktur IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_hadir,
            SUM(CASE WHEN iz.ijin_instruktur IS NOT NULL THEN 1 ELSE 0 END) AS jumlah_izin,
            IFNULL(i.jumlah_keterlambatan_instruktur, 0) AS jumlah_keterlambatan_instruktur
        FROM instrukturs AS i
        LEFT JOIN presensi_instrukturs AS pi ON i.id = pi.id_instruktur AND MONTH(pi.created_at) = ?
        LEFT JOIN ijin_instrukturs AS iz ON i.id = iz.id_instruktur AND MONTH(iz.created_at) = ?
        GROUP BY i.nama_instruktur, i.jumlah_keterlambatan_instruktur
    ', [$bulan, $bulan]);   
        return response([
            'data' => $kinerjaInstruktur,
            'tanggal_cetak' => $tanggalCetak,
        ]);
    }

    public function aktivitasGymBulanan(Request $request)
{
    // date
    $bulan = Carbon::now()->month;
    if ($request->has('month') && !empty($request->month)) {
        $bulan = $request->month;
    }

    // Tanggal Cetak
    $tanggalCetak = Carbon::now();
    $aktivitasGym = booking_gym::where('tanggal_yang_di_booking_gym', '<', $tanggalCetak)
        ->where('status_presensi', "Hadir")
        ->where('is_canceled', 0)
        ->whereMonth('tanggal_yang_di_booking_gym', $bulan)
        ->get()
        ->groupBy(function ($item) {
            // group by tanggal
            $carbonDate = Carbon::createFromFormat('Y-m-d H:i:s', $item->tanggal_yang_di_booking_gym);
            return $carbonDate->toDateTimeString();
        });

    // Count
    $responseData = [];

    foreach ($aktivitasGym as $tanggal => $grup) {
        $count = $grup->count();
        $responseData[] = [
            'tanggal' => $tanggal,
            'count' => $count,
        ];
    }

    return response([
        'data' => $responseData,
        'tanggal_cetak' => $tanggalCetak
    ]);
}

public function aktivitasKelasBulanan(Request $request)
    {
        $bulan = Carbon::now()->month;
        if ($request->has('month') && !empty($request->month)) {
            $bulan = $request->month;
        }
        // dd($bulan);
        //* Tanggal Cetak
        $tanggalCetak = Carbon::now();
        $aktivitasKelas = DB::select('
            SELECT k.nama_kelas AS kelas, i.nama_instruktur AS instruktur, COUNT(bk.no_struk_booking_presensi_kelas) AS jumlah_peserta_kelas, 
                COUNT(CASE WHEN jh.status_jadwal_harian = "diliburkan" THEN 1 ELSE NULL END) AS jumlah_libur
            FROM booking_kelas AS bk
            JOIN jadwal_harians AS jh ON bk.id_jadwal_harian = jh.id_jadwal_harian
            JOIN jadwal__umums AS ju ON jh.id_jadwal_umum = ju.id
            JOIN instrukturs AS i ON ju.id_instruktur = i.id
            JOIN kelas AS k ON ju.id_kelas = k.id
            WHERE MONTH(jh.tanggal_jadwal_harian) = ?
            GROUP BY k.nama_kelas, i.nama_instruktur
        ', [$bulan]);
    
        //akumulasi terlambat direset tiap bulan jam mulai tiap bulan - jam selesai bulan 
        
        return response([
            'data' => $aktivitasKelas,
            'tanggal_cetak' => $tanggalCetak,
        ]);
        
    }

    
}
