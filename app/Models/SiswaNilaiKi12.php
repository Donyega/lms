<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaNilaiKi12 extends Model
{
  protected $guarded = ['id'];

  public function ta()
  {
    return $this->hasone(Ta::class,'id','idta');
  }

  public function idwali()
  {
    return $this->hasone(Pegawai::class,'id','idwali');
  }

  public function siswa()
  {
    return $this->hasone(Siswa::class,'nis','nis');
  }

  public function ki1()
  {
    return $this->hasone(MdDeskripsiKi::class,'id','idki1');
  }

  public function ki2()
  {
    return $this->hasone(MdDeskripsiKi::class,'id','idki2');
  }

}
