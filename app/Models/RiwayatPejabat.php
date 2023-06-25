<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RiwayatPejabat extends Model
{
  protected $guarded = ['id'];

  public function jabatan()
  {
    return $this->hasone(MdJabatan::class,'id','idjabatan');
  }

  public function pejabat()
  {
    return $this->hasone(Pegawai::class,'id','idpegawai');
  }

  public function sk()
  {
    return $this->hasone(RiwayatPejabatSk::class,'id','idsk');
  }

}
