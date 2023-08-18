<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Siswa::with('kelas')->get();
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
        $dataSiswa = new Siswa;

        $rules = [
            'nama' => 'required',
            'tanggal_lahir' => 'required',
            'jenis_kelamin' => 'required',
            'kelas_id' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => true,
                'message' => 'Gagal Memasukan Data',
                'data' => $validator -> errors()
            ]);
        }

        $dataSiswa->nama = $request->nama;
        $dataSiswa->tanggal_lahir = $request->tanggal_lahir;
        $dataSiswa->jenis_kelamin = $request->jenis_kelamin;
        $dataSiswa->kelas_id = $request->kelas_id;

        $post = $dataSiswa->save();

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
    public function show($siswa_id)
    {
        $siswa = Siswa::with('nilai')->find($siswa_id);

        if (!$siswa) {
            return response()->json([
                'status' => false,
                'message' => 'Data Siswa Tidak Ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data Siswa Ditemukan',
            'data' => $siswa
        ], 200);
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
        $dataSiswa = Siswa::find($id);
        if(empty($dataSiswa)){
            return response()->json([
                'status' => false,
                'message' => 'Data Tidak Ditemukan'
            ], 404);
        }

        $rules = [
            'nama' => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required',
            'kelas_id' => 'required'
        ];

        $validator = Validator::make($request->all(),$rules);
        if($validator->fails()){
            return response()->json([
                'status' => true,
                'message' => 'Gagal Update Data',
                'data' => $validator -> errors()
            ]);
        }

        $dataSiswa->nama = $request->nama;
        $dataSiswa->tanggal_lahir = $request->tanggal_lahir;
        $dataSiswa->jenis_kelamin = $request->jenis_kelamin;
        $dataSiswa->kelas_id = $request->kelas_id;

        $post = $dataSiswa->save();

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
        $dataSiswa = Siswa::find($id);
        if(empty($dataSiswa)){
            return response()->json([
                'status' => false,
                'message' => 'Data Tidak Ditemukan'
            ], 404);
        }

        $post = $dataSiswa->delete();

        return response()->json([
            'status' => true,
            'message' => 'Delete Data Sukses',
        ]);
    }


}
