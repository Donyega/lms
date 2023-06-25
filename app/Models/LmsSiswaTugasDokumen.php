<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;
class LmsSiswaTugasDokumen extends Model
{
  protected $guarded = ['id'];

  public function penugasan()
  {
    return $this->hasone(LmsPenugasan::class,'id','idpenugasan');
  }
}
