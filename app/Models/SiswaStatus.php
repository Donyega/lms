<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiswaStatus extends Model
{
  protected $guarded = ['id'];

  public function ta()
  {
    return $this->hasone(Ta::class,'id','idta');
  }

  public function siswa()
  {
    return $this->hasone(Siswa::class,'nis','nis');
  }

  public function status()
  {
    return $this->hasone(MdSiswaStatus::class,'id','idstatus');
  }

}
