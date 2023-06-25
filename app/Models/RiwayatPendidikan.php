<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;

class RiwayatPendidikan extends Model
{
  protected $guarded = ['id'];
  use Compoships;

  public function pendidikan()
  {
    return $this->hasone(MdPendidikan::class,'id','idpendidikan');
  }
}
