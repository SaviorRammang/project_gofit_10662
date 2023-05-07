<?php

namespace App\Http\Controllers;

use App\Http\Resources\MemberResource;
use App\Models\Member;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;


class MemberController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    //     $data = Member::all();

    //     return response([
    //         'status' => true,
    //         'message' => 'Retrieve All Success',
    //         'data' => $data,
    //     ], 200);
    // }

    // /**
    //  * Store a newly created resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @return \Illuminate\Http\Response
    //  */
    // public function store(Request $request)
    // {
    //     //
    //     $storeData = $request->all();
        
    //     $validate = Validator::make($storeData, Member::$rules);

    //     if($validate->fails())
    //         return response(['status' => false,'message' => $validate->errors()], 400);

    //     $data = Member::create($storeData);
    //     return response([
    //         'status' => true,
    //         'message' => 'Add data Success',
    //         'data' => $data,
    //     ], 200);
    // }

    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Member  $Member
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    //     $data = Member::find($id);
    //     if(!is_null($data)){
    //         return response([
    //             'status' => true,
    //             'message' => 'Retrieve data Success',
    //             'data' => $data,
    //         ], 200);
    //     }

    //     return response([
    //         'status' => false,
    //         'message' => 'data Not Found',
    //         'data' => null,
    //     ], 404);
    // }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  \App\Models\Member  $Member
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    //     $data = Member::find($id);

    //     if(is_null($data)){
    //         return response([
    //             'message' => 'data Not Found',
    //             'data' => null,
    //         ], 404);
    //     }

    //     $updateData = $request->all();
    //     $validate = Validator::make($updateData, Member::$rules);

    //     if($validate->fails())
    //         return response(['status'=>false,'message' => $validate->errors()], 400);

    //     if($data->update($updateData)){
    //         return response([
    //             'status'=>true,
    //             'message' => 'Update data Success',
    //             'data' => $data,
    //         ], 200);
    //     }

    //     return response([
    //         'status'=>false,
    //         'message' => 'Update data Failed',
    //         'data' => $data,
    //     ], 400);
    // }

    // /**
    //  * Remove the specified resource from storage.
    //  *
    //  * @param  \App\Models\Member  $Member
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    //     $data = Member::find($id);

    //     if(is_null($data)){
    //         return response([
    //             'status'=>false,
    //             'message' => 'data Not Found',
    //             'data' => null,
    //         ], 404);
    //     }

    //     if($data->delete()){
    //         return response([
    //             'status'=>true,
    //             'message' => 'Delete data Success',
    //             'data' => $data,
    //         ], 200);
    //     }

    //     return response([
    //         'status'=>false,
    //         'message' => 'Delete data Failed',
    //         'data' => null,
    //     ], 400);
    // }
    public function index()
    {
        $member = Member::latest()->get();
        //render view with posts
        return new MemberResource(true, 'List Data Member', $member);
    }

    public function show($id)
    {
        //find post by ID
        $member = Member::findOrfail($id);

        return new MemberResource(true, 'Detail Data', $member);

    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            // 'nama_member' => "required",
            // 'username_member'=>"required",
            // 'tanggal_lahir_member' => "required",
            // 'no_telp_member'=>"required",
            // 'email_member' => "required",
            // 'password_member' => "required",
            // 'alamat_member'=>"required",
            // 'tanggal_aktivasi_member'=>"required",
            // 'saldo_deposit_member'=>"required"
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::create([
            'nama' => $request->nama_member,
            'username' => $request->username_member,
            'email' => $request->email_member,
            'password' => $request->password_member,
            'role' => 'member',
            'email_verified_at' => Carbon::now()
        ]);
        $id_user = $user['id'];
                // dd($id_user);

        //Fungsi Post ke Database
        $member = Member::create([
            'id_user' => $id_user,
            'nama_member'=> $request->nama_member,
            'username_member' => $request->username_member,
            'tanggal_lahir_member' => $request->tanggal_lahir_member,
            'no_telp_member' => $request->no_telp_member,
            'email_member' => $request->email_member,
            'password_member' => $request->password_member,
            'alamat_member' => $request->alamat_member,
            'tanggal_aktivasi_member'=>$request->tanggal_aktivasi_member,
            'saldo_deposit_member'=>$request->saldo_deposit_member
        ]);
        return new MemberResource(true, 'Data Member Berhasil Ditambahkan!', $member);
    }

    public function update(Request $request, Member $member)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama_member' => "required",
            'username_member'=>"required",
            'tanggal_lahir_member' => "required",
            'no_telp_member'=>"required",
            'email_member' => "required",
            'password_member' => "required",
            'alamat_member'=>"required",
            'tanggal_aktivasi_member'=>"required",
            'saldo_deposit_member'=>"required"
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find member by ID
        $member = Member::findOrFail($member->id_member);

        if($member) {

            //member post
            $member->update([
                'nama_member' => $request->nama_member,
                'username_member' => $request->username_member,
                'tanggal_lahir_member' => $request->tanggal_lahir_member,
                'no_telp_member' => $request->no_telp_member,
                'email_member' => $request->email_member,
                'password_member' => $request->password_member,
                'alamat_member' => $request->alamat_member,
                'tanggal_aktivasi_member'=>$request->tanggal_aktivasi_member,
                'saldo_deposit_member'=>$request->saldo_deposit_member
            ]);

            return new MemberResource(true, 'Data Member Berhasil Diubah!', $member);

        }

        //data member not found
        return new MemberResource(false, 'Data Member Tidak Ditemukan!', $member);

    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        $member = Member::findOrfail($id);
        if($member) {
            $member->delete();
            return new MemberResource(true, 'Data Member Dihapus!', $member);
        }
        //data member not found
        return new MemberResource(false, 'Data Member Tidak Ditemukan!', $member);
    }

    public function resetPassword($id_member)
    {
        $tanggal_lahir_member = DB::table('members')->where('id_member', $id_member)->value('tanggal_lahir_member');
        $member = Member::find($id_member);
        $member->update([
            'password_member' => $tanggal_lahir_member,
        ]);
        // alihkan halaman ke halaman departemen
        return new MemberResource(true, 'Password Member Berhasil Direset!',$member);
    }

    // public function resetPassword($id){
    //     $member = Member::findOrFail($id);

    //     if($member) {

    //         //member post
    //         $member->update([
    //             'nama_member' => $request->nama_member,
    //             'username_member' => $request->username_member,
    //             'no_telp_member' => $request->no_telp_member,
    //             'email_member' => $request->email_member,
    //             'password_member' => $request->password_member,
    //             'alamat_member' => $request->alamat_member,
    //             'tanggal_aktivasi_member'=>$request->tanggal_aktivasi_member,
    //             'saldo_deposit_member'=>$request->saldo_deposit_member
    //         ]);

    //         return new MemberResource(true, 'Data Member Berhasil Diubah!', $member);

    //     }

    //     //data member not found
    //     return new MemberResource(false, 'Data Member Tidak Ditemukan!', $member);

    //     }
    }

