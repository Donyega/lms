<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaPindah extends Model
{
  protected $guarded = ['id'];

  public function siswa()
  {
    return $this->hasone(Siswa::class,'nis','nis');
  }
  
}
