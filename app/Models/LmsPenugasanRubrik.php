<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class LmsPenugasanRubrik extends Model
{
  protected $guarded = ['id'];

  public function penugasan()
  {
    return $this->hasone(LmsPenugasan::class,'id','idpenugasan');
  }
}
