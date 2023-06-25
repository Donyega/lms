<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiPresensi extends Model
{
  protected $guarded = ['id'];

  public function pegawai()
  {
    return $this->hasone(Pegawai::class,'id','idpegawai');
  }

  public function user()
  {
    return $this->hasone(User::class,'id','iduser');
  }

  public function ta()
  {
    return $this->hasone(Ta::class,'id','idta');
  }

  public function bulan()
  {
    return $this->hasone(MdBulan::class,'id','idbulan');
  }

}
