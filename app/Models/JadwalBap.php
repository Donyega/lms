<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JadwalBap extends Model
{
  protected $guarded = ['id'];

  public function guru()
  {
    return $this->hasone(Pegawai::class,'id','idguru');
  }

  public function jadwal()
  {
    return $this->hasone(JadwalPelajaran::class,'id','idjadwal');
  }
}
