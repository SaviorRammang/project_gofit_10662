<?php

namespace App\Http\Controllers;

use App\Models\Instruktur;
use App\Models\Member;
use App\Models\Pegawai;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class LoginMobileController extends Controller
{
    public function loginMobile(Request $request)
    {
        try {
            $validateUser = Validator::make($request->all(),
            [
                'email' => 'required|email',
                'password' => 'required'
            ]);

            if($validateUser->fails()){
                return response()->json([
                    'status' => false,
                    'message' => 'validation error',
                    'errors' => $validateUser->errors()
                ], 401);
            }
            
            $user = User::where('email', $request->email)->orWhere('username', $request->email)->first();

            if (is_null($user)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data user tidak ditemukan',
                ], 401);
            }

            if(!Auth::attempt(['email' => $user['email'], 'password' => $request->password])){
                return response()->json([
                    'status' => false,
                    'message' => 'Email atau Password salah',
                ], 401);
            }


            if (!$user->hasVerifiedEmail()) {
                return response()->json([
                    'status' => false,
                    'message' => 'Email belum terverifikasi.',
                ], 401);
            }
            // dd($Instruktur); 
            //* Cek Role Admin, Mo, Kasir
            if($user->role == "Instruktur"){
                
                $Instruktur = Instruktur::where('id_user', $user->id)->first();
                return response()->json([
                    'status' => true,
                    'message' => 'Authenticated',
                    'Instruktur' => $Instruktur,
                    'user' => $user,
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ], 200);
            }

            if($user->role == "Member"){
                
                $Member = Member::where('id_user', $user->id)->first();
                return response([
                    'status' => true,
                    'message' => 'Authenticated',
                    'Member' => $Member,
                    'user' => $user,
                    'token' => $user->createToken("API TOKEN")->plainTextToken
                ], 200);
            }
             
            $pegawai = Pegawai::where('id_user',$user->id)->get();
            return response()->json([
                'status' => true,
                'message' => 'User Logged In Successfully',
                'data' => ['user'=>$user, 'pegawai'=>$pegawai],
                'token' => $user->createToken("API TOKEN")->plainTextToken
            ], 200);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => false,
                'message' => $th->getMessage()
            ], 500);
        }

    }
}
