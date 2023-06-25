<?php

namespace App\Models;

use Awobaz\Compoships\Compoships;
use Illuminate\Database\Eloquent\Model;

class RiwayatWaliKelas extends Model
{
  protected $guarded = ['id'];
  use Compoships;
  
  public function walikelas()
  {
    return $this->hasone(Pegawai::class,'id','idwali');
  }
}
