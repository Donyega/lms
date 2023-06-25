<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaDetil extends Model
{
  protected $guarded = ['id'];

  public function siswa()
  {
    return $this->hasone(Siswa::class,'nis','nis');
  }

  public function asalsekolah()
  {
    return $this->hasone(MdSekolah::class,'id','idasalsekolah');
  }

}
