<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use \Awobaz\Compoships\Compoships;
class LmsEvaluasiSoal extends Model
{
  protected $guarded = ['id'];
  use Compoships;
  public function jawaban()
  {
    return $this->hasMany(LmsEvaluasiJawaban::class,['idmapel','kode'],['idmapel','kode']);
  }

  public function cerita()
  {
    return $this->hasone(LmsEvaluasiCerita::class,'id','idcerita');
  }


  public function user()
  {
    return $this->hasone(User::class,'id','iduser');
  }
}
