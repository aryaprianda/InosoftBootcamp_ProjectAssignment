<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Siswa extends Model
{
    protected $collection = 'siswa';
    protected $fillable = ['nama', 'tanggal_lahir', 'jenis_kelamin', 'kelas_id'];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id', '_id');
    }

    public function nilai()
    {
        return $this->hasOne(Nilai::class, 'siswa_id', '_id');
    }
}
