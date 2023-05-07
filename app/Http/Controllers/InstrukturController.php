<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResource;
use App\Http\Resources\InstrukturResource;
use App\Models\Instruktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InstrukturController extends Controller
{
    // /**
    //  * Display a listing of the resource.
    //  *
    //  * @return \Illuminate\Http\Response
    //  */
    // public function index()
    // {
    //     //
    //     $data = Instruktur::all();

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
        
    //     $validate = Validator::make($storeData, Instruktur::$rules);

    //     if($validate->fails())
    //         return response(['status' => false,'message' => $validate->errors()], 400);

    //     $data = Instruktur::create($storeData);
    //     return response([
    //         'status' => true,
    //         'message' => 'Add data Success',
    //         'data' => $data,
    //     ], 200);
    // }
    
    // /**
    //  * Display the specified resource.
    //  *
    //  * @param  \App\Models\Instruktur  $Instruktur
    //  * @return \Illuminate\Http\Response
    //  */
    // public function show($id)
    // {
    //     //
    //     $data = Instruktur::find($id);
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
    //  * @param  \App\Models\Instruktur  $Instruktur
    //  * @return \Illuminate\Http\Response
    //  */
    // public function update(Request $request, $id)
    // {
    //     //
    //     $data = Instruktur::find($id);

    //     if(is_null($data)){
    //         return response([
    //             'message' => 'data Not Found',
    //             'data' => null,
    //         ], 404);
    //     }

    //     $updateData = $request->all();
    //     $validate = Validator::make($updateData, Instruktur::$rules);

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
    //  * @param  \App\Models\Instruktur  $Instruktur
    //  * @return \Illuminate\Http\Response
    //  */
    // public function destroy($id)
    // {
    //     //
    //     $data = Instruktur::find($id);

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
        $instruktur = Instruktur::latest()->get();
        //render view with posts
        return new InstrukturResource(true, 'List Data Instruktur', $instruktur);
    }

    public function show($id)
    {
        //find post by ID
        $instruktur = Instruktur::findOrfail($id);

        return new InstrukturResource(true, 'Detail Data', $instruktur);

    }

    public function store(Request $request)
    {
        //Validasi Formulir
        $validator = Validator::make($request->all(), [
            'nama_instruktur' => 'required',
            'username_instruktur' => 'required',
            'email_instruktur' => 'required',
            'password_instruktur' =>  'required',
            'no_telp_instruktur' => 'required',
            'alamat_instruktur' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        //Fungsi Post ke Database
        $instruktur = Instruktur::create([
            'nama_instruktur' => $request->nama_instruktur,
            'username_instruktur' => $request->username_instruktur,
            'email_instruktur' => $request->email_instruktur,
            'password_instruktur' => $request->password_instruktur,
            'no_telp_instruktur' => $request->no_telp_instruktur,
            'alamat_instruktur' => $request->alamat_instruktur
        ]);
        return new InstrukturResource(true, 'Data Instruktur Berhasil Ditambahkan!', $instruktur);
    }

    public function update(Request $request, Instruktur $instruktur)
    {
        //set validation
        $validator = Validator::make($request->all(), [
            'nama_instruktur' => 'required',
            'username_instruktur' => 'required',
            'email_instruktur' => 'required',
            'password_instruktur' =>  'required',
            'no_telp_instruktur' => 'required',
            'alamat_instruktur' => 'required'
        ]);
        
        //response error validation
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find instruktur by ID
        $instruktur = Instruktur::findOrFail($instruktur->id);
        //

        if($instruktur) {

            //instruktur post 
            $instruktur->update([
                'nama_instruktur' => $request->nama_instruktur,
                'username_instruktur' => $request->username_instruktur,
                'email_instruktur' => $request->email_instruktur,
                'password_instruktur' => $request->password_instruktur,
                'no_telp_instruktur' => $request->no_telp_instruktur,
                'alamat_instruktur' => $request->alamat_instruktur
            ]);

            return new InstrukturResource(true, 'Data Instruktur Berhasil Diubah!', $instruktur);

        }

        //data instruktur not found
        return new InstrukturResource(false, 'Data Instruktur Tidak Ditemukan!', $instruktur);

    }
    
    /**
     * destroy
     *
     * @param  mixed $id
     * @return void
     */
    public function destroy($id)
    {
        //find instruktur by ID
        $instruktur = Instruktur::findOrfail($id);

        if($instruktur) {

            //delete instruktur
            $instruktur->delete();

            return new InstrukturResource(true, 'Data Instruktur Dihapus!', $instruktur);

        }

        //data instruktur not found
        return new InstrukturResource(false, 'Data Instruktur Tidak Ditemukan!', $instruktur);
    }

}
