<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;
class LmsSiswaTugasNilai extends Model
{
  protected $guarded = ['id'];

  public function rubrik()
  {
    return $this->hasone(LmsPenugasanRubrik::class,'id','idrubrik');
  }
}
