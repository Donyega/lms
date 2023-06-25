<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaNilaiKi34 extends Model
{
  protected $guarded = ['id'];

  public function ta()
  {
    return $this->hasone(Ta::class,'id','idta');
  }

  public function jadwal()
  {
    return $this->hasone(JadwalPelajaran::class,'id','idjadwal');
  }

  public function siswa()
  {
    return $this->hasone(Siswa::class,'nis','nis');
  }

}
