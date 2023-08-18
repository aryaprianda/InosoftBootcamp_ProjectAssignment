<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class KelasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Kelas::with('siswa')->get();
        return response()->json([
            'status' => true,
            'message' => 'Data Ditemukan',
            'data' => $data
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $dataKelas = new Kelas;

        $rules = [
            'nama_kelas' => 'required',
            'tingkat' => 'required',
            'wali_kelas' => 'required',
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => true,
                'message' => 'Gagal Memasukan Data',
                'data' => $validator -> errors()
            ]);
        }

        $dataKelas->nama_kelas = $request->nama_kelas;
        $dataKelas->tingkat = $request->tingkat;
        $dataKelas->wali_kelas = $request->wali_kelas;

        $post = $dataKelas->save();

        return response()->json([
            'status' => true,
            'message' => 'Memasukan Data Sukses',
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Kelas::find($id);
        if($data){
            return response()->json([
                'status' => true,
                'message' => 'Data Ditemukan',
                'data' => $data
            ],200);
        }else{
            return response()->json([
                'status' => true,
                'message' => 'Data Tidak Ditemukan'
            ]);
        }
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
        $dataKelas = Kelas::find($id);
        if(empty($dataKelas)){
            return response()->json([
                'status' => false,
                'message' => 'Data Tidak Ditemukan'
            ], 404);
        }

        $rules = [
            'nama_kelas' => 'required',
            'tingkat' => 'required',
            'wali_kelas' => 'required',
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => true,
                'message' => 'Gagal Update Data',
                'data' => $validator -> errors()
            ]);
        }

        $dataKelas->nama_kelas = $request->nama_kelas;
        $dataKelas->tingkat = $request->tingkat;
        $dataKelas->wali_kelas = $request->wali_kelas;

        $post = $dataKelas->save();

        return response()->json([
            'status' => true,
            'message' => 'Update Data Sukses',
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $dataKelas = Kelas::find($id);
        if(empty($dataKelas)){
            return response()->json([
                'status' => false,
                'message' => 'Data Tidak Ditemukan'
            ], 404);
        }

        $post = $dataKelas->delete();

        return response()->json([
            'status' => true,
            'message' => 'Delete Data Sukses',
        ]);
    }
}
