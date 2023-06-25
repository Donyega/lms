<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;
class LmsSiswaEvaluasi extends Model
{
  protected $guarded = ['id'];

  public function soal()
  {
    return $this->hasmany(LmsSiswaEvaluasiJawaban::class,'idsiswaevaluasi','id');
  }

  public function siswa()
  {
    return $this->hasOne(Siswa::class,'nis','nis');
  }

  public function evaluasi()
  {
    return $this->hasOne(LmsEvaluasi::class,'id','idevaluasi');
  }
}
