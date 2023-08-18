<?php

use App\Http\Controllers\Api\KelasController;
use App\Http\Controllers\Api\SiswaController;
use App\Http\Controllers\Api\NilaiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('siswa', [SiswaController::class,'index']);
Route::get('siswa/{id}',[SiswaController::class,'show']);
Route::post('siswa',[SiswaController::class,'store']);
Route::put('siswa/{id}',[SiswaController::class,'update']);
Route::delete('siswa/{id}',[SiswaController::class,'destroy']);

Route::get('kelas', [KelasController::class,'index']);
Route::get('kelas/{id}',[KelasController::class,'show']);
Route::post('kelas',[KelasController::class,'store']);
Route::put('kelas/{id}',[KelasController::class,'update']);
Route::delete('kelas/{id}',[KelasController::class,'destroy']);

Route::get('siswa/{siswaId}/nilai', [NilaiController::class, 'showSiswaNilai']);
Route::get('nilai/{id}', [NilaiController::class, 'showMataPelajaran']);
Route::post('nilai', [NilaiController::class, 'store']);
Route::delete('nilai/{id}', [NilaiController::class, 'destroy']);



