<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PegawaiDetil extends Model
{
  protected $guarded = ['id'];

  public function pegawai()
  {
    return $this->hasone(Pegawai::class,'id','idpegawai');
  }

  public function jenisptk()
  {
    return $this->hasone(PegawaiJenisPtk::class,'id','idjenisptk');
  }

  public function pangkat()
  {
    return $this->hasone(MdPangkat::class,'id','idpangkat');
  }

}
