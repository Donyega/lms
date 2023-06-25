<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;

class JadwalPelajaranDetil extends Model
{
  protected $guarded = ['id'];
  use Compoships;

  public function jadwal()
  {
    return $this->hasone(JadwalPelajaran::class,'id','idjadwal');
  }

  public function jampelajaran()
  {
    return $this->hasone(MdJamPelajaran::class,'id','idjam');
  }
}
