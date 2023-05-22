<?php

namespace App\Http\Controllers;


use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Pegawai;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class AuthController extends Controller
{
    public function register(Request $request){
        $registrationData = $request->all();

        $validate = Validator::make($registrationData, [
            "nama" => "required",
            "username" => "required",
            "email" => "required|email|unique:users",
            "password" => "required",
        ]);

        if($validate->fails())
            return response(['message' => $validate->errors()], 400);

        $registrationData['password'] = bcrypt($request->password);

        $user = User::create($registrationData);
        $user->sendEmailVerificationNotification();

        return response([
            'status' => true,
            'message' => 'Register Success',
            'user' => $user,
            'token' => $user->createToken("API TOKEN")->plainTextToken
        ], 200);
    }

    public function login(Request $request)
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
            //* Cek Role Admin, Mo, Kasir
            $pegawai = Pegawai::where('id_user',$user->id)->get();
            // dd($pegawai);
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

    // public funtion loginMobile(){
// 
    // }


    public function logout()
    {
        auth()->user()->currentAccessToken()->delete();

        return response()->json([
            'status' => true,
            'message' => 'User Logged Out Successfully',
        ], 200);
    }
     //
    // /**
    //  * Create User
    //  * @param Request $request
    //  * @return User
    //  */
    // public function register(Request $request)
    // {
    //     try {
    //         $data = $request->all();

    //         $validateUser = Validator::make($data,User::$rules);

    //         if($validateUser->fails()){
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'validation error',
    //                 'errors' => $validateUser->errors()
    //             ], 401);
    //         }
            
    //         $data['password'] = Hash::make($data['password']);

    //         $user = User::create($data);
    //         $user->sendEmailVerificationNotification();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'User Created Successfully',
    //             'token' => $user->createToken("API TOKEN")->plainTextToken
    //         ], 200);

    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $th->getMessage()
    //         ], 500);
    //     }
    // }

    // /**
    //  * Login The User
    //  * @param Request $request
    //  * @return User
    //  */
    // public function login(Request $request)
    // {
    //     try {
    //         $validateUser = Validator::make($request->all(),
    //         [
    //             'email' => 'required',
    //             'password' => 'required'
    //         ]);

    //         if($validateUser->fails()){
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'validation error',
    //                 'errors' => $validateUser->errors()
    //             ], 401);
    //         }
            
    //         $user = User::where('email', $request->email)->orWhere('username', $request->email)->first();

    //         if (is_null($user)) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Data user tidak ditemukan',
    //             ], 401);
    //         }

    //         if(!Auth::attempt(['email' => $user['email'], 'password' => $request->password])){
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Email atau Password salah',
    //             ], 401);
    //         }


    //         if (!$user->hasVerifiedEmail()) {
    //             return response()->json([
    //                 'status' => false,
    //                 'message' => 'Email belum terverifikasi.',
    //             ], 401);
    //         }

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'User Logged In Successfully',
    //             'data' => $user,
    //             'token' => $user->createToken("API TOKEN")->plainTextToken
    //         ], 200);

    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $th->getMessage()
    //         ], 500);
    //     }
    // }

    // // logout
    // public function logout()
    // {
    //     try {
    //         auth()->user()->currentAccessToken()->delete();

    //         return response()->json([
    //             'status' => true,
    //             'message' => 'User Logged Out Successfully',
    //         ], 200);

    //     } catch (\Throwable $th) {
    //         return response()->json([
    //             'status' => false,
    //             'message' => $th->getMessage()
    //         ], 500);
    //     }
    // }
} 


    
