<?php

namespace App\Models;

use Jenssegers\Mongodb\Eloquent\Model;

class Kelas extends Model
{
    protected $collection = 'kelas';
    protected $fillable = ['nama_kelas', 'tingkat', 'wali_kelas'];

    public function siswa()
    {
        return $this->hasMany(Siswa::class, 'kelas_id', '_id');
    }
}
