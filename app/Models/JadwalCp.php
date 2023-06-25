<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalCp extends Model
{
  protected $guarded = ['id'];

  public function rpp()
  {
    return $this->hasone(JadwalRpp::class,'id','idrpp');
  }

  public function tujuan()
  {
    return $this->hasmany(JadwalCpTujuan::class,'idcp','id');
  }

  public function ceknilai()
  {
    return $this->hasone(SiswaNilaiDetil::class,'idcp','id')->where('nilai','!=',null);
  }

  public function soal()
  {
    return $this->hasmany(JadwalCpSoal::class,'idcp','id');
  }

}
