<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Nilai;
use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NilaiController extends Controller
{
    public function showSiswaNilai($siswa_id)
    {
        $siswa = Siswa::find($siswa_id);

        if (!$siswa) {
            return response()->json([
                'status' => false,
                'message' => 'Data Siswa Tidak Ditemukan'
            ], 404);
        }

        $nilai = Nilai::where('siswa_id', $siswa_id)->get();

        if ($nilai->isEmpty()) {
            return response()->json([
                'status' => true,
                'message' => 'Data Nilai Siswa Tidak Ditemukan',
                'siswa' => $siswa
            ], 200);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data Nilai Siswa Ditemukan',
            'siswa' => $siswa,
            'data' => $nilai
        ], 200);
    }

    public function showMataPelajaran($id)
    {
        $nilai = Nilai::find($id);

        if (!$nilai) {
            return response()->json([
                'status' => false,
                'message' => 'Data Nilai Tidak Ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data Nilai Ditemukan',
            'data' => $nilai
        ], 200);
    }

    public function calculateNilaiAkhir($latihan_soal, $ulangan_harian, $ulangan_tengah_semester, $ulangan_semester)
    {
        $nilai_latihan_soal = array_sum($latihan_soal) / count($latihan_soal);
        $nilai_ulangan_harian = array_sum($ulangan_harian) / count($ulangan_harian);

        $nilai_akhir = 0.15 * $nilai_latihan_soal + 0.20 * $nilai_ulangan_harian + 0.25 * $ulangan_tengah_semester + 0.40 * $ulangan_semester;

        return round($nilai_akhir, 2);
    }

    public function store(Request $request)
    {
        $rules = [
            'siswa_id' => 'required',
            'mata_pelajaran' => 'required',
            'latihan_soal.*' => 'required',
            'ulangan_harian.*' => 'required',
            'ulangan_tengah_semester' => 'required',
            'ulangan_semester' => 'required'
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal Memasukan Data',
                'data' => $validator->errors()
            ], 400);
        }

        $dataNilai = new Nilai;
        $dataNilai->siswa_id = $request->siswa_id;
        $dataNilai->mata_pelajaran = $request->mata_pelajaran;
        $dataNilai->latihan_soal = $request->latihan_soal;
        $dataNilai->ulangan_harian = $request->ulangan_harian;
        $dataNilai->ulangan_tengah_semester = $request->ulangan_tengah_semester;
        $dataNilai->ulangan_semester = $request->ulangan_semester;

        $nilai_akhir = $this->calculateNilaiAkhir(
            $request->latihan_soal,
            $request->ulangan_harian,
            $request->ulangan_tengah_semester,
            $request->ulangan_semester
        );

        $dataNilai->nilai_akhir = $nilai_akhir;

        $dataNilai->save();

        return response()->json([
            'status' => true,
            'message' => 'Memasukan Data Sukses'
        ], 201);
    }


}
