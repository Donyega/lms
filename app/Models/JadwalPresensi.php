<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalPresensi extends Model
{
  protected $guarded = ['id'];

  public function siswa()
  {
    return $this->hasone(Siswa::class,'nis','nis');
  }

  public function jadwal()
  {
    return $this->hasone(JadwalPelajaran::class,'id','idjadwal');
  }
}
