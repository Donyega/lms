<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;
class LmsSiswaTugas extends Model
{
  protected $guarded = ['id'];

  public function jadwal()
  {
    return $this->hasone(JadwalPelajaran::class,'id','idjadwal');
  }

  public function penugasan()
  {
    return $this->hasone(LmsPenugasan::class,'id','idpenugasan');
  }

  public function siswa()
  {
    return $this->hasone(Siswa::class,'nis','nis');
  }

  public function kelompok()
  {
    return $this->hasmany(LmsSiswaTugas::class,'idkelompok','idkelompok');
  }

  public function detilnilai()
  {
    return $this->hasmany(LmsSiswaTugasNilai::class,'idtugas','id');
  }

  public function dokumenindividu()
  {
    return $this->hasmany(LmsSiswaTugasDokumen::class,'idtugas','id');
  }
  
  public function dokumenkelompok()
  {
    return $this->hasmany(LmsSiswaTugasDokumen::class,'idkelompok','idkelompok');
  }
}
