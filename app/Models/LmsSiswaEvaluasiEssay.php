<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;
class LmsSiswaEvaluasiEssay extends Model
{
  protected $guarded = ['id'];

  public function soal()
  {
    return $this->hasone(LmsEvaluasiSoal::class,'id','idsoal');
  }

}
