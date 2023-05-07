<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstrukturController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PegawaiController;
use App\Http\Controllers\VerificationController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login'])->middleware('cors');
Route::put('reset/{id_member}', 'App\Http\Controllers\MemberController@resetPassword');


// Route::post('register', 'Controllers\AuthController@register');
// Route::post('login', 'Controllers\AuthController@login');

Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify'); // Make sure to keep this as your route name
Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');



// Route::group(['middleware' => ['auth:sanctum']], function () {

//     // Route::get('/instruktur', [InstrukturController::class, 'index']);
//     // Route::post('/instruktur', [InstrukturController::class, 'store']);
//     // // Route::post('/instruktur', [InstrukturController::class, 'show']);
//     // Route::put('/instruktur/{id}', [InstrukturController::class, 'update']);
//     // Route::delete('/instrukturdelete/{id}', [InstrukturController::class, 'destroy']);

//     // Route::resource('/instruktur', InstrukturController::class);
//     // Route::get('/instruktur/{id}', [InstrukturController::class, 'show']);

//     // Route::resource('/member', MemberController::class);
//     // Route::get('/member/{id_member}', [MemberController::class, 'show']);


//     // Route::get('instruktur', 'Controllers\InstrukturController@index');
//     // Route::get('instruktur/{id}', 'Controllers\InstrukturController@show');
//     // Route::post('instruktur/{id}', 'Controllers\InstrukturController@store');
//     // Route::delete('instruktur/{id}', 'Controllers\InstrukturController@destroy');
//     // Route::put('instruktur/{id}', 'Controllers\InstrukturController@update');




//     Route::get('/user', [AuthController::class, 'user']);
//     Route::get('/logout', [AuthController::class, 'logout']);

//     // return $request->user();
// });
Route::apiResource('/instruktur', App\Http\Controllers\InstrukturController::class);
Route::apiResource('/pegawai', App\Http\Controllers\PegawaiController::class);
Route::apiResource('/member', App\Http\Controllers\MemberController::class);
Route::apiResource('/kelas', App\Http\Controllers\KelasController::class);
Route::apiResource('/jadwal_umum', App\Http\Controllers\JadwalUmumController::class);
Route::apiResource('/jadwal_harian', App\Http\Controllers\JadwalHarianController::class);
Route::apiResource('/promo', App\Http\Controllers\PromoController::class);
Route::apiResource('/transaksi_deposit_uang', App\Http\Controllers\TransaksiDepositUangController::class);


Route::get('/loginpegawai', '\App\Http\Controllers\pegawaiController@loginPegawai');