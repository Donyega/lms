<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;
class LmsPenugasan extends Model
{
  protected $guarded = ['id'];
  use Compoships;

  public function jadwal()
  {
    return $this->hasone(JadwalPelajaran::class,'id','idjadwal');
  }

  public function tugassiswa()
  {
    return $this->hasmany(LmsSiswaTugas::class,'idpenugasan','id');
  }

  public function rubrik()
  {
    return $this->hasmany(LmsPenugasanRubrik::class,'idpenugasan','id');
  }

  public function kumpul()
  {
    return $this->hasmany(LmsSiswaTugas::class,'idpenugasan','id');
  }

  public function user()
  {
    return $this->hasone(User::class,'id','iduser');
  }
}
