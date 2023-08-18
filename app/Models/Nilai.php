<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Nilai extends Model
{
    protected $collection = 'nilai';
    protected $fillable = [
        'siswa_id', 'mata_pelajaran', 'latihan_soal', 'ulangan_harian',
        'ulangan_tengah_semester', 'ulangan_semester'
    ];

    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id', '_id');
    }
}
