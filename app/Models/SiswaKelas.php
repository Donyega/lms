<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

class SiswaKelas extends Model
{
  protected $guarded = ['id'];
  use Compoships;

  public function siswa()
  {
    return $this->hasone(Siswa::class,'nis','nis');
  }

  public function kelas()
  {
    return $this->hasone(MdKelas::class,'id','idkelas');
  }

  public function riwayatwali()
  {
    return $this->hasone(RiwayatWaliKelas::class,['idta','idkelas'],['idta','idkelas']);
  }
}
