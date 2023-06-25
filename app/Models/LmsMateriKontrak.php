<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;
class LmsMateriKontrak extends Model
{
  protected $guarded = ['id'];
  use Compoships;

  public function pegawai()
  {
    return $this->hasone(Pegawai::class,'id','idguru');
  }
}
